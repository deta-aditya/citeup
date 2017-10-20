<?php

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

/*
 * API v1 Namespace Group
 */
Route::group([
    'namespace' => 'App\Modules\Api\V1\Controllers', 'prefix' => '/v1',
], function () {

    /*
     * Resource Routes 
     */
    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@insert');
    Route::get('/users/current', 'UserController@current');
    Route::get('/users/{user}', 'UserController@show');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@remove');
    Route::get('/users/{user}/keys', 'UserController@keys');
    Route::post('/users/{user}/keys', 'UserController@grantKeys');
    Route::get('/users/{user}/alerts', 'UserController@alerts');
    Route::post('/users/{user}/alerts', 'UserController@seeAlerts');
    Route::get('/users/{user}/edits', 'UserController@edits');
    Route::post('/users/{user}/password', 'UserController@changePassword');

    Route::put('/entrants/{entry}', 'EntryController@updateEntrantProfile');
    Route::post('/entrants/{entry}/disqualify', 'EntryController@disqualify');
    Route::post('/entrants/{entry}/qualify', 'EntryController@qualify');
    Route::post('/entrants/{entry}/approve', 'EntryController@approve');

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
    Route::get('/activities/{activity}/edits', 'ActivityController@edits');

    Route::get('/schedules', 'ScheduleController@index');
    Route::post('/schedules', 'ScheduleController@insert');
    Route::get('/schedules/{schedule}', 'ScheduleController@show');
    Route::put('/schedules/{schedule}', 'ScheduleController@update');
    Route::delete('/schedules/{schedule}', 'ScheduleController@remove');
    Route::get('/schedules/{schedule}/edits', 'ScheduleController@edits');

    Route::get('/entries', 'EntryController@index');
    Route::post('/entries', 'EntryController@insert');
    Route::get('/entries/{entry}', 'EntryController@show');
    Route::put('/entries/{entry}', 'EntryController@update');
    Route::delete('/entries/{entry}', 'EntryController@remove');
    Route::get('/entries/{entry}/submissions', 'EntryController@submissions');
    Route::post('/entries/{entry}/submissions', 'EntryController@addSubmission');
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
    Route::get('/attempts/{attempt}/answers', 'AttemptController@answers');
    Route::post('/attempts/{attempt}/answers', 'AttemptController@addAnswers');

    Route::get('/questions', 'QuestionController@index');
    Route::post('/questions', 'QuestionController@insert');
    Route::get('/questions/{question}', 'QuestionController@show');
    Route::put('/questions/{question}', 'QuestionController@update');
    Route::delete('/questions/{question}', 'QuestionController@remove');
    Route::get('/questions/{question}/choices', 'QuestionController@choices');
    Route::post('/questions/{question}/choices', 'QuestionController@addChoices');
    Route::get('/questions/{question}/answers', 'QuestionController@answers');

    Route::get('/choices', 'ChoiceController@index');
    Route::post('/choices', 'ChoiceController@insert');
    Route::get('/choices/{choice}', 'ChoiceController@show');
    Route::put('/choices/{choice}', 'ChoiceController@update');
    Route::delete('/choices/{choice}', 'ChoiceController@remove');

    Route::get('/answers', 'AnswerController@index');
    Route::post('/answers', 'AnswerController@insert');
    Route::get('/answers/{answer}', 'AnswerController@show');
    Route::delete('/answers/{answer}', 'AnswerController@remove');

    Route::get('/galleries', 'GalleryController@index');
    Route::post('/galleries', 'GalleryController@insert');
    Route::get('/galleries/{gallery}', 'GalleryController@show');
    Route::put('/galleries/{gallery}', 'GalleryController@update');
    Route::delete('/galleries/{gallery}', 'GalleryController@remove');
    Route::get('/galleries/{gallery}/edits', 'GalleryController@edits');

    Route::get('/news', 'NewsController@index');
    Route::post('/news', 'NewsController@insert');
    Route::get('/news/{news}', 'NewsController@show');
    Route::put('/news/{news}', 'NewsController@update');
    Route::delete('/news/{news}', 'NewsController@remove');
    Route::get('/news/{news}/edits', 'NewsController@edits');

    Route::get('/sponsors', 'SponsorController@index');
    Route::post('/sponsors', 'SponsorController@insert');
    Route::get('/sponsors/{sponsor}', 'SponsorController@show');
    Route::put('/sponsors/{sponsor}', 'SponsorController@update');
    Route::delete('/sponsors/{sponsor}', 'SponsorController@remove');
    Route::get('/sponsors/{sponsor}/edits', 'SponsorController@edits');

    Route::get('/faqs', 'FaqController@index');
    Route::post('/faqs', 'FaqController@insert');
    Route::get('/faqs/{faq}', 'FaqController@show');
    Route::put('/faqs/{faq}', 'FaqController@update');
    Route::delete('/faqs/{faq}', 'FaqController@remove');
    Route::get('/faqs/{faq}/edits', 'FaqController@edits');

    Route::get('/contact-people', 'ContactPersonController@index');
    Route::post('/contact-people', 'ContactPersonController@insert');
    Route::get('/contact-people/{contact}', 'ContactPersonController@show');
    Route::put('/contact-people/{contact}', 'ContactPersonController@update');
    Route::delete('/contact-people/{contact}', 'ContactPersonController@remove');

    Route::get('/html-contents', 'HtmlContentController@index');
    Route::post('/html-contents', 'HtmlContentController@insert');
    Route::get('/html-contents/{content}', 'HtmlContentController@show');
    Route::put('/html-contents/{content}', 'HtmlContentController@update');
    Route::delete('/html-contents/{content}', 'HtmlContentController@remove');
    Route::get('/html-contents/{content}/edits', 'HtmlContentController@edits');
    
    Route::get('/edits', 'EditController@index');

    Route::get('/stages', 'StageController@index');
    Route::get('/stages/current', 'StageController@current');

    Route::get('/chats', 'ChatController@index');
    Route::post('/chats', 'ChatController@insert');
    Route::post('/chats/read', 'ChatController@read');
    
    /*
     * Storage Routes
     */
    Route::post('/storage', 'StorageController@insert');
    Route::delete('/storage', 'StorageController@delete');

    /*
     * Import/Export Routes 
     */
    Route::post('/import', 'IEController@import');
    Route::post('/export', 'IEController@export');

    /*
     * Config Routes
     */
    Route::get('/config', 'ConfigController@index');
    Route::post('/config', 'ConfigController@insert');

    Route::post('/unicorn/generator', 'ConfigController@generator');

    /*
     * Bulk Routes
     */
    // Route::get('/bulk', 'BulkController@get');
    // Route::post('/bulk', 'BulkController@post');

});
