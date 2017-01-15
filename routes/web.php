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

//Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/tin-tuc-hoat-dong', 'HomeController@news')->name('news');
Route::get('/gioi-thieu', 'HomeController@about')->name('about');

Route::get('/faq', 'ArticleController@searchQnA')->name('search');