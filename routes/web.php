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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@welcome')->name('welcome');
Auth::routes(['register' => false]);
Route::post('/contact', 'HomeController@contact')->name('contact');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/domain/{id}', 'HomeController@domainShow')->name('domain.show');
    Route::post('/add/domain', 'HomeController@domainAdd')->name('domain.add');
    Route::post('/delete/{id}/domain', 'HomeController@domainDelete')->name('domain.delete');
    Route::post('/edit/{id}/domain', 'HomeController@domainEdit')->name('domain.edit');
    Route::post('/seo/{id}/domain', 'HomeController@seoChange')->name('domain.seo');
    Route::delete('/slug/delete', 'HomeController@slugDelete')->name('slug.delete');
    Route::put('/slug/{id}/insert', 'HomeController@slugInsert')->name('slug.insert');
    Route::post('/site-map/{url}', 'HomeController@siteMap')->name('sitemap');
    Route::group(['prefix' => 'phone', 'as' => 'phone.'], function () {
        Route::get('/', 'HomeController@phone')->name('page');
        Route::post('/upload', 'HomeController@upload')->name('upload');
    });
});
