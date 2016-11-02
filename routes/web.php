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
Route::get(
	'{all}', function () { 
		return view('landing');
	}
);
Route::post('/login', ['as' => 'login', 'uses' => 'HomeController@login']);
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
