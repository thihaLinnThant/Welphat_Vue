<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/admin', 'CategoryController@get_categories_api');

Route::get('/admin/books', 'BookController@get_books_api');

Route::get('/admin/categories', 'CategoryController@get_categories_api');

Route::get('/admin/tags', 'TagController@get_tags_api');

Route::get('/admin/publishers', 'PublisherController@get_publishers_api');

Route::get('/admin/dummy', 'CategoryController@get_categories_api');