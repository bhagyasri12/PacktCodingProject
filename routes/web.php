<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/','/login');


Auth::routes();


Route::get('/home', [\App\Http\Controllers\BookController::class,'home'])->name('home')->middleware('auth');

Route::get('migrate-books', [\App\Http\Controllers\BookController::class,'migrate_to_elasticsearch']);
Route::post('search-books', [\App\Http\Controllers\BookController::class, 'search']);

Route::resource('/books', \App\Http\Controllers\BookController::class);
Route::view('customer-view', 'books.customer-home')->middleware('admin');
Route::post('get-books', [\App\Http\Controllers\BookController::class,'getBooks']);
