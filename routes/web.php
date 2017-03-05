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

Route::get('/home', 'HomeController@index');
Route::get('/datasets', 'DatasetController@index');
Route::get('/predict/heart', 'PredictionController@getHeart');
Route::post('/predict/heart', 'PredictionController@postHeart');
Route::get('/predict/diabetes', 'PredictionController@getDiabetes');
Route::post('/predict/diabetes', 'PredictionController@postDiabetes');