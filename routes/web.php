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

Route::get('/', 'Web\SearchController@search')->name('home');

Route::get('about', 'Web\AboutController@about')->name('about');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('faq/index', 'Web\FaqController@index')->name('manage.faq');
Route::get('faq/create', 'Web\FaqController@create')->name('manage.faq.create');
Route::post('faq/create', 'Web\FaqController@store')->name('manage.faq.store');
Route::get('faq/{id}', 'Web\FaqController@show')->name('faq.show');
Route::get('faq/{id}/edit', 'Web\FaqController@edit')->name('manage.faq.edit');
Route::post('faq/{id}/edit', 'Web\FaqController@update')->name('manage.faq.update');
Route::post('faq/{id}/delete', 'Web\FaqController@destroy')->name('manage.faq.delete');
Route::get('faq/{slug}', 'Web\FaqController@slug')->name('faq.slug');

Route::get('articles', 'Web\ArticleController@index')->name('articles');
Route::get('articles/index', 'Web\ArticleController@manage')->name('manage.article');
Route::get('articles/create', 'Web\ArticleController@create')->name('manage.article.create');
Route::post('articles/create', 'Web\ArticleController@store')->name('manage.article.store');
Route::get('articles/{id}','Web\ArticleController@show')->name('articles.show');
Route::get('articles/{id}/edit', 'Web\ArticleController@edit')->name('manage.article.edit');
Route::post('articles/{id}/edit', 'Web\ArticleController@update')->name('manage.article.update');
Route::post('articles/{id}/delete', 'Web\ArticleController@destroy')->name('manage.article.delete');
Route::get('articles/{slug}', 'Web\ArticleController@slug')->name('articles.slug');

Route::get('search-log', 'Web\SearchLogController@index')->name('manage.search_log');
Route::post('search-log/{id}/delete', 'Web\SearchLogController@delete')->name('manage.search_log.delete');
Route::post('search-log/cleanup', 'Web\SearchLogController@cleanup')->name('manage.search_log.cleanup');

Route::get('users', 'Web\UserController@index')->name('manage.user');
Route::get('users/create', 'Web\UserController@create')->name('manage.user.create');
Route::post('users/create', 'Web\UserController@store')->name('manage.user.store');
Route::get('users/{id}/edit', 'Web\UserController@edit')->name('manage.user.edit');
Route::post('users/{id}/edit', 'Web\UserController@update')->name('manage.user.update');
Route::post('users/{id}/delete', 'Web\UserController@destroy')->name('manage.user.delete');

Route::get('account/change-password', 'Auth\ChangePasswordController@show')->name('auth.password.change.show');
Route::post('account/change-password', 'Auth\ChangePasswordController@change')->name('auth.password.change');

Route::get('contacts', 'Web\ContactController@index')->name('contact.index');
Route::get('contacts/index', 'Web\ContactController@manage')->name('manage.contact');
Route::post('contacts/upload', 'Web\ContactController@upload')->name('manage.contact.upload');
Route::get('contacts/export', 'Web\ContactController@export')->name('manage.contact.export');
Route::get('contacts/detail', 'Web\ContactController@detail')->name('contact.detail');
Route::get('contacts/download/{file_name}', 'Web\ContactController@download')->name('manage.contact.download');
Route::post('contacts/delete', 'Web\ContactController@delete')->name('manage.contact.delete');
Route::get('contacts/create', 'Web\ContactController@create')->name('manage.contact.create');
Route::post('contacts/create', 'Web\ContactController@store')->name('manage.contact.store');
Route::get('contacts/edit', 'Web\ContactController@edit')->name('manage.contact.edit');
Route::post('contacts/{id}/edit', 'Web\ContactController@update')->name('manage.contact.update');
Route::get('contacts/{id}', 'Web\ContactController@show')->name('contact.show');
Route::get('contacts/{slug}', 'Web\ContactController@slug')->name('contact.slug');

Route::get('backup', 'Web\BackupController@index')->name('manage.backup');
Route::post('backup/run', 'Web\BackupController@backup')->name('manage.backup.run');
Route::get('backup/download/{file_name}', 'Web\BackupController@download')->name('manage.backup.download');
Route::post('backup/delete/{file_name}', 'Web\BackupController@delete')->name('manage.backup.delete');

Route::get('links', 'Web\LinkController@index')->name('links');
Route::get('links/index', 'Web\LinkController@manage')->name('manage.links');
Route::get('links/create', 'Web\LinkController@create')->name('manage.links.create');
Route::post('links/create', 'Web\LinkController@store')->name('manage.links.store');
Route::get('links/{id}/edit', 'Web\LinkController@edit')->name('manage.links.edit');
Route::post('links/{id}/edit', 'Web\LinkController@update')->name('manage.links.update');
Route::post('links/{id}/delete', 'Web\LinkController@delete')->name('manage.links.delete');

Route::get('feedback', 'Web\FeedbackController@index')->name('manage.feedback');
Route::get('feedback/create', 'Web\FeedbackController@create')->name('feedback.create');
Route::post('feedback/create', 'Web\FeedbackController@store')->name('feedback.store');
Route::post('feedback/{id}/process', 'Web\FeedbackController@process')->name('manage.feedback.process');
Route::post('feedback/{id}/delete', 'Web\FeedbackController@delete')->name('manage.feedback.delete');
Route::get('feedback/{id}/detail', 'Web\FeedbackController@detail')->name('manage.feedback.detail');

Route::get("sitemap.xml", 'Web\SitemapController@sitemap');

Route::get('hong', 'Web\RedirectController@hong');
Route::get('hongdiemthi', 'Web\RedirectController@hong');
Route::get('UET-Q&A', 'Web\RedirectController@home');
Route::get('tags/{tag}', 'Web\RedirectController@tag');
Route::get('positions/{tag}', 'Web\RedirectController@tag');
Route::get('blogs', 'Web\RedirectController@articles');
Route::get('news/public', 'Web\RedirectController@home');
Route::get('news/public/{any}', 'Web\RedirectController@rewrite');