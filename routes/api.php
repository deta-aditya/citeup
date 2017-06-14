<?php

use Illuminate\Http\Request;
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
    // User::getFillable(); 
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

    Route::get('/keys', 'KeyController@index');
    Route::post('/keys', 'KeyController@insert');
    Route::get('/keys/{key}', 'KeyController@show');
    Route::put('/keys/{key}', 'KeyController@update');
    Route::delete('/keys/{key}', 'KeyController@remove');
    Route::get('/keys/{key}/users', 'KeyController@users');
    Route::post('/keys/{key}/users', 'KeyController@registerUsers');

    Route::post('/activities', 'ActivityController@insert');
    Route::put('/activities/{activity}', 'ActivityController@update');

    Route::post('/storage', 'StorageController@insert');
    Route::delete('/storage', 'StorageController@delete');

});
