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

Route::get('/file/{encode_name}', 'FileStorageController@renderFile')->name('file.render');

Route::middleware('auth:api')->group(function(){
    Route::get('/user', 'UserController@userInfo')->name('user.info');
    Route::put('/user/{user}', 'UserController@update')->name('user.update');
    Route::post('/user', 'UserController@store')->name('user.store');
    Route::post('/user/logout', 'UserController@logout')->name('user.logout');
});

Route::middleware('auth:api')->prefix('activity')->group(function(){
    Route::apiResource('ActivityType', 'ActivityTypeController');
    Route::post('ActivityBasic/filter', 'ActivityBasicController@filter')->name('ActivityBasic.filter');
    Route::apiResource('ActivityBasic', 'ActivityBasicController');
    Route::apiResource('ActivityApply', 'ActivityApplyController');
});
