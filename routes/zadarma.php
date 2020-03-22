<?php

use Illuminate\Support\Facades\Route;

Route::get('/call','ZadarmaController@call')->name('zadarma.call')->middleware(['auth']);
Route::post('/event','ZadarmaController@event')->name('zadarma.event');
Route::post('/menu',   'ZadarmaController@menu'  )->name('zadarma.menu');
Route::get('/answer','ZadarmaController@answer')->name('zadarma.answer');
Route::get('/fallback','ZadarmaController@fallback')->name('zadarma.fallback');
