<?php

use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//--------------------------------------------------------------------------------------------------------
//  ROUTES
//


//--------------------------------------------------------------------------------
//  BOOK Routes being used for testing
//
Route::post('/books', 'BooksController@store');

//  Here /{book} is necessary to match
//  the model binding in the BooksController
//
Route::patch('/books/{book}', 'BooksController@update');

Route::delete('/books/{book}', 'BooksController@destroy');

//  END BOOK ROUTES
//--------------------------------------------------------------------------------



//--------------------------------------------------------------------------------
//  AUTHOR Routes being used for testing
//
Route::post('author', 'AuthorsController@store');

//  END AUTHOR ROUTES
//--------------------------------------------------------------------------------


//
//  END ROUTES
//--------------------------------------------------------------------------------------------------------
