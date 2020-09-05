<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/admin/books', 'BookController@get_books_api');
Route::get('/admin/books/lastrecord','BookController@get_lastBook_api');
Route::get('/admin/books/onerecord/{id}', 'BookController@get_oneRecord_api');
Route::get('/admin/books/{id}','BookController@get_oneRecord_api');
Route::get('/admin/books/search/{value}','BookController@book_search');


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
Route::get('/admin/users/{id}', 'UserController@get_oneRecord_api');

Route::get('/admin/categories', 'CategoryController@get_categories_api');
Route::get('/admin/categories/lastrecord','CategoryController@get_lastCategory_api');
Route::get('/admin/categories/onerecord/{id}', 'CategoryController@get_oneRecord_api');
Route::get('/admin/categories/{id}', 'CategoryController@get_oneRecord_api');

Route::get('/admin/tags', 'TagController@get_tags_api');
Route::get('/admin/tags/lastrecord','TagController@get_lastTag_api');
Route::get('/admin/tags/onerecord/{id}', 'TagController@get_oneRecord_api');
Route::get('/admin/tags/{id}', 'TagController@get_oneRecord_api');

Route::get('/admin/publishers', 'PublisherController@get_publishers_api');
Route::get('/admin/publishers/lastrecord','PublisherController@get_lastPublisher_api');
Route::get('/admin/publishers/onerecord/{id}', 'PublisherController@get_oneRecord_api');
Route::get('/admin/publishers/{id}','PublisherController@get_oneRecord_api');

Route::get('/admin/suppliers', 'SupplierController@get_suppliers_api');
Route::get('/admin/suppliers/lastrecord','SupplierController@get_lastSupplier_api');
Route::get('/admin/suppliers/onerecord/{id}', 'SupplierController@get_oneRecord_api');
Route::get('/admin/suppliers/{id}', 'SupplierController@get_oneRecord_api');


Route::get('/admin/orders', 'OrderController@get_orders_api');
Route::get('/admin/orders/lastrecord','OrderController@get_lastorder_api');
Route::get('/admin/orders/onerecord/{id}', 'OrderController@get_oneRecord_api');
Route::get('/admin/orders/{id}', 'OrderController@get_oneRecord_api');


Route::get('/admin/notifications', 'AdminNotificationController@get_all_notifications_api')->middleware('auth:admin_api');
Route::get('/admin/notifications/latest', 'AdminNotificationController@get_latest_notifications_api');
Route::get('/admin/notifications/lastrecord', 'AdminNotificationController@get_lastNotification_api')->middleware('auth:admin_api');

Route::get('/admin/dummy', 'CategoryController@get_categories_api');

Route::get('/admin/comments', 'CommentController@get_comments_api');

Route::get('/admin/overview', 'OverviewController@get_overview_api');
