<?php

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/calendars', 'CalendarController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
