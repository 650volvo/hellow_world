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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('login','Controller@login');
Route::any('register','Controller@register');
Route::any('recordlist','Controller@recordlist');
Route::any('add_comment','Controller@add_comment');
Route::any('delete_comment','Controller@delete_comment');
Route::any('edit_add_comment','Controller@edit_add_comment');
Route::any('get_comment','Controller@api_get_comment');

Route::any('member','Controller@member');
Route::any('clone','Controller@clone');
