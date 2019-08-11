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

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user/detail', 'Api\AuthController@details');

    // Resolution
    Route::get('/resolutions', 'Api\ResolutionController@index');
    Route::post('/resolutions', 'Api\ResolutionController@store');
    Route::put('/resolutions/{id}', 'Api\ResolutionController@update');
    Route::delete('/resolutions/{id}', 'Api\ResolutionController@destroy');
});
