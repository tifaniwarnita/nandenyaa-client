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
Route::get('/login', function () { 
		return view('login', ['response' => null]);
});
Route::post('/login', ['as' => 'login', 'uses' => 'HomeController@login']);
Route::get('/register', function () { 
		return view('register', ['response' => null]);
});
Route::post('/register', ['as' => 'login', 'uses' => 'HomeController@register']);
Route::post('/friend', ['as' => 'friend', 'uses' => 'HomeController@addFriend']);
Route::get('/friend/{username}/{friend_username}', ['as' => 'friend.index', 'uses' => 'HomeController@friendIndex']);
Route::post('/friend/{username}/{friend_username}', ['as' => 'friend.chat', 'uses' => 'HomeController@chat']);
Route::get('/group/{username}/{group_id}', ['as' => 'group.index', 'uses' => 'HomeController@groupIndex']);
Route::post('/group', ['as' => 'group', 'uses' => 'HomeController@createGroup']);
Route::post('/group/update', ['as' => 'group.update', 'uses' => 'HomeController@updateGroup']);
Route::post('/group/delete', ['as' => 'group.delete', 'uses' => 'HomeController@deleteGroup']);
