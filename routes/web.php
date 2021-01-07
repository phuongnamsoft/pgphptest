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

Route::group([], function () {

    // Get user profile with id get query parameter
    Route::get('/', 'UserController@index');

    // Get user profile with id parameter
    Route::get('/user/{id}', 'UserController@view');

    // Update user comment
    Route::post('/user', 'UserController@update');

});
