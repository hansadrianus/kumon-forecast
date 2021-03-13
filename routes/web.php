<?php

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
    return redirect()->route('home');
});

Auth::routes([
    'reset' => false,
    'verify' => false
]);

// Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // route dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    
    
    // route student
    Route::get('/student', 'StudentController@index')->name('student.index');
    Route::get('/student/create', 'StudentController@create')->name('student.create');
    Route::post('/student/store', 'StudentController@store')->name('student.store');
    Route::get('/student/edit/{id}', 'StudentController@edit')->name('student.edit');
    Route::post('/student/update/{id}', 'StudentController@update')->name('student.update');
    Route::get('/student/delete/{id}', 'StudentController@delete')->name('student.delete');
    Route::get('/student/view/{id}', 'StudentController@view')->name('student.view');
    
    // route student score
    Route::post('/student/score/store', 'StudentController@storeScore')->name('student.score.store');
    Route::post('/student/score/import', 'StudentController@studentScoreImport')->name('student.score.import');

    // route forecast
    Route::get('/forecast', 'ForecastController@index')->name('forecast.index');
    Route::post('/forecast/result', 'ForecastController@result')->name('forecast.result');
    
    // route users
    Route::get('/staff', 'StaffController@index')->name('staff.index');
// });

