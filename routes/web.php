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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index')->name('threads');

Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('threads.replies.store');
Route::get('/threads/{channel}', 'ThreadsController@index')->name('threads.channel.show');
Route::get('/threads?by={slug}', 'ThreadsController@by')->name('threads.by');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorites');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show');
