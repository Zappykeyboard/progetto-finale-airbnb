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


Route::get('/', 'IndexController@index')->name('index');

Auth::routes();

//richiede autorizzazione
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index')->name('users.index');

Route::post('/search','SearchPageController@SearchWithQuery')
      ->name('searchWithQuery');
ROute::get('/search', 'SearchPageController@index')
      ->name('search.index');

Route::get('/apt/{id}', 'ApartmentController@show')
      ->name('apt.show');

Route::get('new/apt', 'ApartmentController@create')
      ->name('apt.create')
      ->middleware('auth');

Route::post('/', 'ApartmentController@store')
      ->name('apt.store')
      ->middleware('auth');
