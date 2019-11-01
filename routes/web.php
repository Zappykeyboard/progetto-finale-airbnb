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
use App\Apartment;

Route::get('/', function () {

    $apts = Apartment::where('active', '1')
              -> inRandomOrder()
              -> take(10)
              -> get();
    return view('welcome', compact('apts'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index')->name('users.index');
