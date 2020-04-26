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

Route::redirect('/', 'posts-jquery');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('posts-jquery', 'PostController@jquery')->name('posts.jquery');
Route::get('posts-vue', 'PostController@vue')->name('posts.vue');
Route::post('posts/rate', 'PostController@ratePost')->name('posts.ratePost');
