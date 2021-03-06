<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->action('LogViewController@index');
    } else {
        return view('index');
    }
    
});

Route::view('/about', 'about');
Route::view('/how-to-use', 'how_to_use');

Auth::routes();

Route::middleware('auth:web', 'throttle:60,1')->group(function () {
    Route::get('home', 'LogViewController@index');

    Route::post('logs/store', 'LogViewController@store');
    Route::post('logs/delete', 'LogViewController@delete');

    Route::get('bikes', 'BikeViewController@index');
    Route::post('bikes/store', 'BikeViewController@store');
    Route::post('bikes/sync-strava-bikes', 'BikeViewController@getStravaGear');
    Route::post('bikes/store-strava-bikes', 'BikeViewController@storeStravaGear');

    Route::get('settings', 'UserSettingsController@index');
    Route::post('settings/store', 'UserSettingsController@store');
    Route::post('settings/connect-strava', 'UserSettingsController@connectStrava');
    Route::get('strava/complete-registration', 'UserSettingsController@completeRegistration');

});
