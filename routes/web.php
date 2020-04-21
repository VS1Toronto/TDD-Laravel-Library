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
//  Route being used for testing
//
Route::post('/books', 'BooksController@store');

//  Here /{book} is necessary to match
//  the model binding in the BooksController
//
Route::patch('/books/{book}', 'BooksController@update');
//--------------------------------------------------------------------------------------------------------
