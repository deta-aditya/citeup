<?php

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

/*
 * Original Namespace Group
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    
    /*
     * Authentication Routes
     */    
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/logout', 'LoginController@logout')->name('logout');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('/password/reset', 'ResetPasswordController@reset');
    });
    
    Route::get('/home', 'HomeController@index')->name('home');

});

/*
 * Web Group 
 */
Route::group(['namespace' => 'App\Web'], function () {

    /*
     * Front Subapp 
     */
    Route::group(['namespace' => 'Front\Controllers'], function () {

        Route::get('/',                     'FrontController@index')        ->name('root');
        Route::get('/about',                'AboutController@index')        ->name('about');
        Route::get('/activities/{t?}',      'ActivitiesController@index')   ->name('activities');
        Route::get('/faqs',                 'FaqsController@index')         ->name('faqs');
        Route::get('/news',                 'NewsController@index')         ->name('news');
        Route::get('/news/{news}/{slug?}',  'NewsController@item')          ->name('news.item');

    });

    /*
     * Auth Subapp 
     */
    Route::group(['namespace' => 'Auth\Controllers'], function () {

        Route::get('/login', 'LoginController@form')->name('login.form');
        Route::post('/login', 'LoginController@login')->name('login');
        Route::get('/register/{id}/{name?}', 'RegisterController@form')->name('register.form');
        Route::get('/register', 'RegisterController@index')->name('register.index');
        Route::post('/register/lomba-logika', 'RegisterController@registerLombaLogika')->name('register.lomba-logika');
        Route::post('/register/lomba-desain', 'RegisterController@registerLombaDesain')->name('register.lomba-desain');
        Route::post('/register/seminar-i-t', 'RegisterController@registerSeminarIt')->name('register.seminar-it');

    });

    /*
     * Dashboard Subapp 
     */
    Route::group(['namespace' => 'Dashboard\Controllers'], function () {
        
        Route::get('/panel/{vue?}', 'DashboardController@index')->name('dashboard')->where('vue', '[\/\w\.-]*');
        Route::get('/elimination', 'DashboardController@elimination')->name('elimination');
        Route::get('/submission', 'DashboardController@submission')->name('submission');
        Route::get('/unicorn/generator/why', 'DashboardController@unicorn');
        
    });

});
