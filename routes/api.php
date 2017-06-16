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

    Route::get('/entries/{entry}', 'EntryController@show');
    Route::post('/entries/{entry}', 'EntryController@modify');
    Route::get('/entries/{entry}/submissions', 'EntryController@submissions');
    Route::post('/entries/{entry}/submissions', 'EntryController@addSubmission');
    Route::get('/entries/{entry}/documents', 'EntryController@documents');
    Route::post('/entries/{entry}/documents', 'EntryController@addDocument');
    Route::get('/entries/{entry}/testimonials', 'EntryController@testimonials');
    Route::post('/entries/{entry}/testimonials', 'EntryController@addTestimonial');
    Route::get('/entries/{entry}/attempts', 'EntryController@attempts');
    Route::post('/entries/{entry}/attempts', 'EntryController@startAttempt');

    Route::get('/submissions', 'SubmissionController@index');
    Route::post('/submissions', 'SubmissionController@insert');
    Route::get('/submissions/{submission}', 'SubmissionController@show');
    Route::put('/submissions/{submission}', 'SubmissionController@update');
    Route::delete('/submissions/{submission}', 'SubmissionController@remove');

    Route::get('/documents', 'DocumentController@index');
    Route::post('/documents', 'DocumentController@insert');
    Route::get('/documents/{document}', 'DocumentController@show');
    Route::put('/documents/{document}', 'DocumentController@update');
    Route::delete('/documents/{document}', 'DocumentController@remove');

    Route::get('/testimonials', 'TestimonialController@index');
    Route::post('/testimonials', 'TestimonialController@insert');
    Route::get('/testimonials/{testimonial}', 'TestimonialController@show');
    Route::put('/testimonials/{testimonial}', 'TestimonialController@update');
    Route::delete('/testimonials/{testimonial}', 'TestimonialController@remove');

    Route::get('/attempts', 'AttemptController@index');
    Route::post('/attempts', 'AttemptController@start');
    Route::get('/attempts/{attempt}', 'AttemptController@show');
    Route::put('/attempts/{attempt}', 'AttemptController@finish');
    Route::delete('/attempts/{attempt}', 'AttemptController@remove');

    Route::post('/storage', 'StorageController@insert');
    Route::delete('/storage', 'StorageController@delete');

});
