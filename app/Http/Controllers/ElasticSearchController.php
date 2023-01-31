<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchController extends Controller
{
    protected $client;
    protected $books_index = 'books';

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function addBook(Book $book){
        $params = [
            'index' => $this->books_index,
            'id' => $book->id,
            'body' => $book->toArray()
        ];
        $response = $this->client->index($params);
        return $response;
    }

    public static function delete_book(Book $book){
        $controller = new ElasticSearchController();
        $controller->deleteBook($book);
    }

    public function deleteBook(Book $book){
        $params = [
            'index' => $this->books_index,
            'id' => $book->id,
        ];
        $this->client->delete($params);
    }

    public static function add_book(Book $book){
        $controller = new ElasticSearchController();
        return $controller->addBook($book);
    }

    public function search_books($query){
        $body = [];
        if($query){
            $body['query'] = [
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
                        [
                            'wildcard' => [
                                'description' => "*{$query}*"
                            ]
                        ],
                    ],
                ],
            ];
        }
        $params = [
            'index' => $this->books_index,
            'body' => $body
        ];

        $response = $this->client->search($params);

        $data = [];
        foreach($response['hits']['hits'] as $hit){
            $data[] = $hit['_source'];
        }

        $total =  $response['hits']['total']['value'];

        return $data;
    }

    public static function search($query){
        $controller = new ElasticSearchController();
        return $controller->search_books($query);
    }
}
