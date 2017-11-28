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

Route::get('/', 'Controller@welcome');
Route::get('/ggg', 'Controller@welcome');
Route::get('/test', 'Controller@test_function');
Route::get('/login','Controller@page_login');
Route::get('/member','Controller@page_member');

Route::any('comment','Controller@get_comment');