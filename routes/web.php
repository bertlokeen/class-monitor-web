<?php

Auth::routes();

Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('admin', 'AdminController', ['middleware' => ['role:admin']]);

    Route::group(['prefix' => 'announcements'], function() {
        Route::get('/', 'AnnouncementController@index')->name('announcements.index');
        Route::get('/create', 'AnnouncementController@create')->name('announcements.create');
        Route::post('/create', 'AnnouncementController@store')->name('announcements.store');

        Route::get('/{id?}/edit', 'AnnouncementController@index')->name('announcements.edit');

        Route::delete('/{announcement}/destroy', 'AnnouncementController@destroy')->name('announcements.destroy');

        Route::delete('/{announcement}', 'AnnouncementController@destroy')->name('announcements.delete');
        Route::post('/{announcement}/comment', 'AnnouncementController@comment')->name('announcements.comment.store');
        Route::post('/{announcement}/like', 'AnnouncementController@like')->name('announcements.likes.store');
    });

    Route::resource('/students', 'StudentController');

    Route::get('/students', 'StudentController@index')->name('students.index')->middleware('role:admin|faculty');

    Route::get('/students/{student}/attendance-log', 'StudentController@attendanceLog')->name('students.attendance-log')->middleware('role:student');

    Route::group(['prefix' => 'faculty'], function() {
        Route::group(['middleware' => ['role:admin|faculty']], function() {
            Route::get('/', 'FacultyController@index')->name('faculty.index');
            Route::get('/create', 'FacultyController@create')->name('faculty.create');
            Route::post('/create', 'FacultyController@store')->name('faculty.store');
            Route::get('/{faculty}/edit', 'FacultyController@edit')->name('faculty.edit');
            Route::put('/{faculty}', 'FacultyController@update')->name('faculty.update');
            Route::delete('/{faculty}', 'FacultyController@destroy')->name('faculty.destroy');
        });

        Route::get('/{faculty}', 'FacultyController@show')->name('faculty.show');
    });
    
    Route::resource('/subjects', 'SubjectController');

    Route::get('/subjects/{name}/student/{id}', 'SubjectController@showGradingSheet')->name('subjects.show-grade-sheet')->middleware('role:faculty');

    Route::get('/subjects/{name}/show-by-name', 'SubjectController@showByName')->name('subjects.show-by-name')->middleware('role:student');

    Route::get('/subjects/{subject}/edit', 'SubjectController@edit')->name('subjects.edit')->middleware('role:admin');

    Route::resource('/classes', 'SectionClassController');

    Route::post('/classes/{class_id}/store-attendance', 'AttendanceController@store')->name('attendance.store');

    Route::post('/classes/{id}/assign-student', 'SectionClassController@assignStudent')->name('classes.assign-student');

    Route::get('/classes/{class_id}/un-assign-student/{student_id}', 'SectionClassController@unAssignStudent')->name('classes.un-assign-student');

    Route::post('/classes/{class_id}/store-activity', 'ActivityController@store')->name('activity.store');

    Route::get('/activities', 'ActivityController@index')->name('activity.index');

    Route::get('/activities/{activity}', 'ActivityController@show')->name('activity.show');

    Route::post('/activities/{activity}/store-score', 'ActivityController@storeScores')->name('activity.store-scores');

    Route::get('/reports/{class_id}/student-grades', 'SectionClassController@exportToPdf')->name('export.pdf');
});