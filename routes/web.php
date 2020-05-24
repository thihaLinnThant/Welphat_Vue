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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', 'CategoryController@get_home_web');

//books
Route::get('/admin/books', 'BookController@get_books_web');

//categories
Route::get('/admin/categories', 'CategoryController@get_categories_web');
Route::post('/admin/categories/addcategory', 'CategoryController@create');

Route::get('/admin/publishers', 'PublisherController@get_publishers_web');
Route::get('/admin/tags', 'TagController@get_tags_web');

Route::get('/admin/dummy', 'CategoryController@get_home_web');

