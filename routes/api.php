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
    Route::get('/users/{user}', 'UserController@show');
    Route::post('/users', 'UserController@insert');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@remove');

    Route::post('/storages', 'StorageController@insert');
    Route::delete('/storages', 'StorageController@delete');

});
