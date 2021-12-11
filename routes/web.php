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
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'PostController@index')->name('posts');

Auth::routes();

Route::get('/home', [App\Http\Controllers\PostController::class, 'index'])->name('posts');

Route::get('/post/create', 'PostController@create')->name('post.create');
Route::post('/post/store', 'PostController@store')->name('post.store');

Route::get('/posts', 'PostController@index')->name('posts');
Route::get('/myposts', 'PostController@myposts')->name('myposts');
Route::get('/post/show/{id}', 'PostController@show')->name('post.show');

Route::post('/like/{id}', 'PostController@likepost')->name('post.like');
Route::post('/unlike/{id}', 'PostController@unlikepost')->name('post.unlike');

Route::get('/post/edit/{id}', 'PostController@edit')->name('post.edit');
Route::post('/update', 'PostController@update')->name('post.update');
Route::delete('/post/del/{id}', 'PostController@destroy')->name('post.destroy');

Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

Route::get('/like', 'LikeController@store')->name('like');