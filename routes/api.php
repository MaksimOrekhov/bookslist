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

// Books list
Route::get('books', 'BooksController@index');

// Book single list
Route::get('book/{id}', 'BooksController@show');

// Create new book
Route::post('book', 'BooksController@store');

// Update book
Route::put('book', 'BooksController@store');

// Delete book
Route::delete('book/{id}', 'BooksController@destroy');