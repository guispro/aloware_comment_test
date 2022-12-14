<?php

use App\Http\Controllers\CommentsController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comments', 'CommentsController@index');
Route::post('/comments', 'CommentsController@new');
Route::post('/comments/{id}', 'CommentsController@reply');
Route::put('/comments/{id}', 'CommentsController@update');
Route::delete('/comments/{id}', 'CommentsController@delete');