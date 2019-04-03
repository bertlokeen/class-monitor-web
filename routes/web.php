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


Route::group(['middleware' => 'auth'], function() {

    Route::resource('admin', 'AdminController', ['middleware' => ['role:admin']]);

    Route::group(['prefix' => 'announcements'], function() {
        Route::get('/', 'AnnouncementController@index')->name('announcements');
        Route::get('/create', 'AnnouncementController@create')->name('announcements.create');
        Route::post('/create', 'AnnouncementController@store')->name('announcements.store');
        Route::delete('/{announcement}', 'AnnouncementController@destroy')->name('announcements.delete');
        Route::post('/{announcement}/comment', 'AnnouncementController@comment')->name('announcements.comment.store');
        Route::post('/{announcement}/like', 'AnnouncementController@like')->name('announcements.likes.store');
    });

    Route::resource('/students', 'StudentController');

    Route::group(['prefix' => 'faculty'], function() {
        Route::get('/', 'FacultyController@index')->name('faculty.index');
        Route::get('/create', 'FacultyController@create')->name('faculty.create');
        Route::post('/create', 'FacultyController@store')->name('faculty.store');
        Route::get('/{faculty}', 'FacultyController@show')->name('faculty.show');
        Route::get('/{faculty}/edit', 'FacultyController@edit')->name('faculty.edit');
        Route::put('/{faculty}', 'FacultyController@update')->name('faculty.update');
        Route::delete('/{faculty}', 'FacultyController@destroy')->name('faculty.destroy');
    });

    Route::resource('/subjects', 'SubjectController');
});