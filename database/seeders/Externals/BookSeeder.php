<?php

namespace Database\Seeders\Externals;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $url = 'https://fakerapi.it/api/v1/books?_quantity=200';
        $books_data = json_decode(file_get_contents($url), true)['data'];
        Book::insert($books_data);
    }
}
