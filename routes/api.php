<?php

use App\Repositories\Contract\ActivityTypeRepositoryInterface;
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
Route::get('/test', function(ActivityTypeRepositoryInterface $activityTypeRepository) {
    dd(123456);
});
Route::get('/file/{encode_name}', 'FileStorageController@renderFile')->name('file.render');
Route::post('/user', 'UserController@store')->name('user.store');

Route::middleware('auth:api')->prefix('user')->group(function(){
    Route::get('/', 'UserController@userInfo')->name('user.info');
    Route::put('/{user}', 'UserController@update')->name('user.update');
    Route::post('/logout', 'UserController@logout')->name('user.logout');
    Route::get('/menus', 'MenuController@getMenuListByUser')->name('user.menus');
});

Route::middleware('auth:api')->prefix('activity')->group(function(){
    Route::apiResource('ActivityType', 'ActivityTypeController');
    Route::delete('ActivityType/delete/Multi', 'ActivityTypeController@deleteMulti');
    Route::post('ActivityType/filter', 'ActivityTypeController@filter')->name('ActivityType.filter');
    Route::apiResource('ActivityBasic', 'ActivityBasicController');
    Route::post('ActivityBasic/filter', 'ActivityBasicController@filter')->name('ActivityBasic.filter');
    Route::apiResource('ActivityApply', 'ActivityApplyController');
    Route::post('ActivityApply/filter', 'ActivityApplyController@filter')->name('ActivityApply.filter');
});
