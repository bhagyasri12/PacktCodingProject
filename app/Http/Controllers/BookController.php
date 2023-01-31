<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['getBooks', 'search', 'home']);
    }

    public function home(Request $request){
        $user = Auth::user();
        if(!$user->is_admin)
            return view('books.customer-home');
        else
            return view('books.home');
    }

    public function getBooks(Request $request){
        $limit = $request->limit ?? 15;
        $search_string = $request->search_string;
        $published_date = $request->published_date;
        $query = Book::query();
        if($published_date){
            $query = $query->where('published',$published_date);
        }
        if($search_string){
            $query->where('title','LIKE', "%{$search_string}%")
            ->orWhere('author','LIKE', "%{$search_string}%")
            ->orWhere('isbn','LIKE', "%{$search_string}%")
            ->orWhere('genre','LIKE', "%{$search_string}%");
        }
        return $query->paginate($limit);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $local_storage = false;
        $book = new Book();
        return view('books.create', compact('book','local_storage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = \request()->validate([
            'title'=>'required',
            'author'=>'required',
            'genre'=>'required',
            'description'=>'required',
            'isbn'=>'required',
            'published'=>'required',
            'publisher'=>'required',
        ]);
        if($request->file('book_image')){
            $data['image'] = $this->file_upload($request);
        }
        if($request->book_id){
            $book = Book::find($request->book_id);
            $book->update($data);
        }
        else{
            Book::create($data);
        }

        ElasticSearchController::add_book($book);
        return redirect('/home');
    }

    public function file_upload(Request $request){
        $imageName = Str::random(20) . '.' . $request->file('book_image')->extension();
        $request->file('book_image')->storeAs('public/book-images', $imageName);
        return $imageName;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $local_storage = true;
        if(str_contains($book['image'], "http://")){
            $local_storage = false;
        }
        return view('books.create', compact('book','local_storage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy(Book $book)
    {
        $book->delete();
        ElasticSearchController::delete_book($book);
        return ['success'=>true,'msg'=>'deleted'];
    }

    public function migrate_to_elasticsearch(){
        $books = Book::all();
        foreach($books as $book){
            ElasticSearchController::add_book($book);
        }
        return response()->json(['message'=>'Books migrated to elasticsearch']);
    }

    public function search(Request $request){
        $query = $request->search;
        $date = $request->date;

        $body = [];
        $must_conditions = [];
        if($query){
            $must_conditions[] = [
                'bool' => [
                    'should' => [
                        [
                            'wildcard' => [
                                'title' => "*{$query}*"
                            ]
                        ],
                        [
                            'wildcard' => [
                                'author' => "*{$query}*"
                            ]
                        ],
                    ],
                ],
            ];
        }

        if($date){
            $must_conditions[] = [
                'range' => [
                    'published' => [
                        'gte' => $date,
                        'lte' => $date,
                    ]
                ]
            ];
        }

        if(count($must_conditions) > 0){
            $body['query'] = [
                'bool' => [
                    'must' => $must_conditions
                ]
            ];
        }

        $params = [
            'index' => 'books',
            'body' => $body
        ];

        $client = ClientBuilder::create()->build();
        $response = $client->search($params);

        $data = [];
        foreach($response['hits']['hits'] as $hit){
            $data[] = $hit['_source'];
        }

        return response()->json($data);
    }
}
