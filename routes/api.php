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

Route::get('/admin/authors', 'AuthorController@get_authors_api');
Route::get('/admin/authors/lastrecord','AuthorController@get_lastAuthor_api');
Route::get('/admin/authors/onerecord/{id}','AuthorController@get_oneRecord_api');
Route::get('/admin/authors/{id}','AuthorController@get_oneRecord_api');


Route::get('/admin/admins','AdminController@get_admins_api');
Route::get('/admin/admins/lastrecord','AdminController@get_lastAdmin_api');
Route::get('/admin/admins/adminSuper/onerecord/{id}','AdminController@get_oneRecord_api');
Route::get('/admin/admins/onerecord/{id}','AdminController@get_oneRecord_api');

Route::get('/admin/users', 'UserController@get_users_api');
Route::get('/admin/users/lastrecord','UserController@get_lastUser_api');
Route::get('/admin/users/onerecord/{id}', 'UserController@get_oneRecord_api');

Route::get('/admin/categories', 'CategoryController@get_categories_api');
Route::get('/admin/categories/lastrecord','CategoryController@get_lastCategory_api');
Route::get('/admin/categories/onerecord/{id}', 'CategoryController@get_oneRecord_api');

Route::get('/admin/tags', 'TagController@get_tags_api');
Route::get('/admin/tags/lastrecord','TagController@get_lastTag_api');
Route::get('/admin/tags/onerecord/{id}', 'TagController@get_oneRecord_api');


Route::get('/admin/publishers', 'PublisherController@get_publishers_api');
Route::get('/admin/publishers/lastrecord','PublisherController@get_lastPublisher_api');
Route::get('/admin/publishers/onerecord/{id}', 'PublisherController@get_oneRecord_api');

Route::get('/admin/orders', 'OrderController@get_orders_api');
Route::get('/admin/orders/lastrecord','OrderController@get_lastorder_api');
Route::get('/admin/orders/onerecord/{id}', 'OrderController@get_oneRecord_api');


Route::get('/admin/dummy', 'CategoryController@get_categories_api');

Route::get('/admin/comments', 'CommentController@get_comments_api');
