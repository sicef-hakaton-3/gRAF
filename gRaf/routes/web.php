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

Route::any('/', ['uses' => 'HomeController@index', 'as' => 'home' ]);
Route::any('/location', 'HomeController@city');

Route::any('/days', 'HomeController@days');
