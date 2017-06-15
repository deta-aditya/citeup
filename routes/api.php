<?php

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

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

Route::get('/user', function (Request $request) {
    return User::find(19)->entry;
});

/*
 * API v1 Namespace Group
 */
Route::group([
    'namespace' => 'App\Modules\Api\V1\Controllers', 'prefix' => '/v1',
], function () {

    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@insert');
    Route::get('/users/{user}', 'UserController@show');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@remove');
    Route::get('/users/{user}/keys', 'UserController@keys');
    Route::post('/users/{user}/keys', 'UserController@grantKeys');
    Route::get('/users/{user}/alerts', 'UserController@alerts');
    Route::post('/users/{user}/alerts', 'UserController@seeAlerts');
    Route::post('/users/{user}/entries', 'UserController@modifyEntry');

    Route::get('/keys', 'KeyController@index');
    Route::post('/keys', 'KeyController@insert');
    Route::get('/keys/{key}', 'KeyController@show');
    Route::put('/keys/{key}', 'KeyController@update');
    Route::delete('/keys/{key}', 'KeyController@remove');
    Route::get('/keys/{key}/users', 'KeyController@users');
    Route::post('/keys/{key}/users', 'KeyController@registerUsers');

    Route::get('/alerts', 'AlertController@index');
    Route::post('/alerts', 'AlertController@insert');
    Route::get('/alerts/{alert}', 'AlertController@show');
    Route::put('/alerts/{alert}', 'AlertController@update');
    Route::delete('/alerts/{alert}', 'AlertController@remove');
    Route::get('/alerts/{alert}/users', 'AlertController@users');
    Route::post('/alerts/{alert}/users', 'AlertController@announceUsers');

    Route::get('/activities', 'ActivityController@index');
    Route::post('/activities', 'ActivityController@insert');
    Route::get('/activities/{activity}', 'ActivityController@show');
    Route::put('/activities/{activity}', 'ActivityController@update');
    Route::delete('/activities/{activity}', 'ActivityController@remove');
    Route::get('/activities/{activity}/users', 'ActivityController@users');
    Route::get('/activities/{activity}/schedules', 'ActivityController@schedules');
    Route::post('/activities/{activity}/schedules', 'ActivityController@makeSchedule');

    Route::get('/schedules', 'ScheduleController@index');
    Route::post('/schedules', 'ScheduleController@insert');
    Route::get('/schedules/{schedule}', 'ScheduleController@show');
    Route::put('/schedules/{schedule}', 'ScheduleController@update');
    Route::delete('/schedules/{schedule}', 'ScheduleController@remove');

    Route::post('/entries/{entry}', 'EntryController@modify');

    Route::post('/storage', 'StorageController@insert');
    Route::delete('/storage', 'StorageController@delete');

});
