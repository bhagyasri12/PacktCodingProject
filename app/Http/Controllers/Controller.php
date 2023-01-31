<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    //uploading data from given url to DB
    // we can also chunk the data if the no.of records to be inserted are more

    public function uploadData(Request $request){
        $url = 'https://fakerapi.it/api/v1/books?_quantity=200';
        $books_data = json_decode(file_get_contents($url), true)['data'];
        Book::insert($books_data);
        return ['msg'=>'data inserted'];
    }
}
