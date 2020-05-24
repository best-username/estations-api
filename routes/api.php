<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('stations', 'StationController@index');
Route::get('station/{id}', 'StationController@show');
Route::post('station', 'StationController@store');
Route::put('station/{id}', 'StationController@update');
Route::delete('station/{id}', 'StationController@delete');

Route::post('city/stations', 'StationController@showByCity');
Route::post('station/nearest', 'StationController@showNearest');