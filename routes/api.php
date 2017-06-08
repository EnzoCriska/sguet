<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('articles', 'Api\ArticleApiController@index')->name('api.article.index');

Route::get('contacts/roots', 'Api\ContactApiController@roots')->name('api.contacts.roots');
Route::get('contacts/children', 'Api\ContactApiController@children')->name('api.contacts.children');
Route::get('contacts/data', 'Api\ContactApiController@data')->name('api.contacts.data');
