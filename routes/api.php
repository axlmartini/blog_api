<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Post;
use App\Comment;

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

Route::post('register', 'Auth\ApiRegisterController@register');
Route::post('login', 'Auth\ApiLoginController@login');
Route::post('logout', 'Auth\ApiLoginController@logout');

// Allow only access to endpoints for authorized users
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('posts', 'PostController@index');
    Route::get('posts/{post}', 'PostController@show');
    Route::post('posts', 'PostController@store');
    Route::put('posts/{post}', 'PostController@update');
    Route::delete('posts/{post}', 'PostController@delete');

    Route::get('comments', 'CommentController@index');
    Route::get('comments/{comment}', 'CommentController@show');
    Route::post('comments', 'CommentController@store');
    Route::put('comments/{comment}', 'CommentController@update');
    Route::delete('comments/{comment}', 'CommentController@delete');
});
