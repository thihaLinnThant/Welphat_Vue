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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login.admin');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm')->name('register.admin');

Route::post('/login/admin', 'Auth\LoginController@loginAdmin')->name('login.admin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin')->name('register.admin');

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin/books', 'BookController@get_books_web');
    Route::get('/admin/books/register', 'BookController@register_web');

    Route::get('/admin/authors', 'AuthorController@get_authors_web');
    Route::post('/admin/authors/register', 'AuthorController@create');

    Route::get('/admin/categories', 'CategoryController@get_categories_web');
    Route::post('/admin/categories/addcategory', 'CategoryController@create');
    Route::post('/admin/categories/update/{id}', 'CategoryController@update');
    Route::post('/admin/categories/delete/{id}','CategoryController@destroy');

    Route::get('/admin/comments', 'CommentController@get_comments_web');

    Route::get('/admin/admins','AdminController@get_admins_web');

    Route::get('/admin/users','UserController@get_users_web');

    Route::get('/admin/publishers', 'PublisherController@get_publishers_web');
    Route::post('/admin/publishers/addpublisher', 'PublisherController@create');

    Route::get('/admin/tags', 'TagController@get_tags_web');
    Route::post('/admin/tags/addtag', 'TagController@create');

    Route::get('/admin/dummy', 'CategoryController@get_home_web');

});
