<?php

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

Route::get('/', function () { return view('welcome');});

// for github login
Route::get('github', 'Github\GithubController@top');
Route::post('github/issue', 'Github\GithubController@createIssue');
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

// for Default Authentication
Auth::routes();

// user page
Route::get('users/{id}', 'UserController@show');

// only for Authenticated user
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'PostsController@index')->name('home');

    Route::get('/my_page', 'UserController@mypage');
    Route::get('/my_page/edit', 'UserController@edit');
    Route::put('/my_page/update', 'UserController@update');

    Route::get('post', 'PostsController@create');
    Route::post('post/store', 'PostsController@store');

    // Likes
    Route::get('posts/{post_id}/likes/list', 'LikesController@show');
    Route::post('posts/{post_id}/likes', 'LikesController@store');
    Route::delete('posts/{post_id}/likes/delete', 'LikesController@delete');
        
});



