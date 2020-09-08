<?php

use Illuminate\Http\Request;

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




// USER
Route::post('login','api\AuthController@login');
Route::post('register','api\AuthController@register');
Route::get('logout','api\AuthController@logout');

//POST
Route::post('posts/create','api\PostsController@create');
Route::post('posts/delete','api\PostsController@delete');
Route::post('posts/update','api\PostsController@update');
Route::post('posts','api\PostsController@post');