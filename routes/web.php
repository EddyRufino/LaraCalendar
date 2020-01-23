<?php

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('/calendars', 'CalendarController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
