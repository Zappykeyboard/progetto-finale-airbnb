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

Route::get('/search','ApartmentController@index')->name('apt.index');

Route::get('/apt/{id}', 'ApartmentController@show')
      ->name('apt.show');

Route::get('/new/apt', 'ApartmentController@create')
      ->name('apt.create')
      ->middleware('auth');

Route::post('/', 'ApartmentController@store')
      ->name('apt.store')
      ->middleware('auth');

Route::get('/apt/{id}/edit', 'ApartmentController@edit')
      ->name('apt.edit')
      ->middleware('auth');

Route::post('/{id}', 'ApartmentController@update')
      ->name('apt.update')
      ->middleware('auth');

Route::get('/{id}', 'ApartmentController@destroy')
      ->name('apt.destroy')
      ->middleware('auth');
