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

Auth::routes();

Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::group(['prefix' => 'announcements', 'middleware' => 'auth'], function() {
    Route::get('/', 'AnnouncementController@index')->name('announcements');
    Route::get('/create', 'AnnouncementController@create')->name('announcements.create');
    Route::post('/create', 'AnnouncementController@store')->name('announcements.store');
    Route::delete('/{announcement}', 'AnnouncementController@destroy')->name('announcements.delete');
    Route::post('/{announcement}/comment', 'AnnouncementController@comment')->name('announcements.comment.store');
    Route::post('/{announcement}/like', 'AnnouncementController@like')->name('announcements.likes.store');
});

Route::group(['prefix' => 'students', 'middleware' => 'auth'], function() {
    Route::get('/', 'StudentController@index')->name('students');

    Route::get('/create', 'StudentController@create')->name('students.create');
    Route::post('/create', 'StudentController@store')->name('students.store');
});

Route::group(['prefix' => 'faculty', 'middleware' => 'auth'], function() {
    Route::get('/', 'FacultyController@index')->name('faculty');

    Route::get('/create', 'FacultyController@create')->name('faculty.create');
    Route::post('/create', 'FacultyController@store')->name('faculty.store');
});

Route::group(['prefix' => 'sections', 'middleware' => 'auth'], function() {
    Route::get('/', 'SectionController@index')->name('sections');

    Route::get('/create', 'SectionController@create')->name('sections.create');
    Route::post('/create', 'SectionController@store')->name('sections.store');
});