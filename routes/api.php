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

Route::post('/user', 'UserController@store')->name('user.store');
Route::middleware('auth:api')->post('/user/logout', 'UserController@logout')->name('user.logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->put('/user/{user}', 'UserController@update')->name('user.update');

Route::prefix('activity')->group(function(){
    Route::apiResource('ActivityType', 'ActivityTypeController');
    Route::post('ActivityBasic/filter', 'ActivityBasicController@filter')->name('ActivityBasic.filter');
    Route::apiResource('ActivityBasic', 'ActivityBasicController');
    Route::apiResource('ActivityApply', 'ActivityApplyController');
});
