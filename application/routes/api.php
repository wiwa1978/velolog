<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Bike;

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

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::post('refreshtoken', 'UserController@refreshToken');

Route::get('/unauthorized', 'UserController@unauthorized');

Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::post('logout', 'UserController@logout');
    Route::get('details', 'UserController@details');
    Route::get('bikes', 'BikeController@index');
    Route::get('bikes/{bike}', 'BikeController@show');
    Route::post('bikes', 'BikeController@store');
    Route::put('bikes/{bike}', 'BikeController@update');
    Route::delete('bikes/{bike}', 'BikeController@delete');
});
