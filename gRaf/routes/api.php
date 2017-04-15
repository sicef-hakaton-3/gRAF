<?php

use Illuminate\Http\Request;

Route::get('/days', "CitiesController@days");
Route::get('/{city}', "CitiesController@getCityData");



//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');
