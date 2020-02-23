<?php

use Illuminate\Support\Facades\Route;

Route::get('/call','NexmoController@call')->name('nexmo.call')->middleware(['auth']);
Route::post('/event','NexmoController@event')->name('nexmo.event');
Route::post('/menu',   'NexmoController@menu'  )->name('nexmo.menu');
Route::get('/answer','NexmoController@answer')->name('nexmo.answer');
Route::get('/fallback','NexmoController@fallback')->name('fallback');
