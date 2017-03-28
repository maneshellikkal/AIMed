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

Route::get('/', 'HomeController@index');

Auth::routes();

// Datasets Related Routes
Route::get('/datasets', 'DatasetController@index');
Route::get('/datasets/publish', 'DatasetController@create');
Route::post('/datasets', 'DatasetController@store');
Route::get('/d/{dataset}', 'DatasetController@show');
Route::get('/d/{dataset}/edit', 'DatasetController@edit');
Route::put('/d/{dataset}', 'DatasetController@update');
Route::post('/d/{dataset}/file', 'DatasetFileController@upload');

// Code Related Routes
Route::get('/codes', 'CodeController@index');
Route::get('/c/{dataset}/publish', 'CodeController@create');
Route::post('/codes', 'CodeController@store');
Route::get('/c/{code}', 'CodeController@show');
Route::get('/c/{code}/edit', 'CodeController@edit');
Route::put('/c/{code}', 'CodeController@update');

Route::get('/predict/heart', 'HeartDiseasePredictionController@form');
Route::post('/predict/heart', 'HeartDiseasePredictionController@predict');
Route::get('/predict/diabetes', 'DiabetesPredictionController@form');
Route::post('/predict/diabetes', 'DiabetesPredictionController@predict');