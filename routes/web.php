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

Route::get('/', function () {
    return view('welcome');
});


// user
Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'UserController@getLogin')->middleware('auth');
	Route::post('/', 'UserController@postLogin')->middleware('auth');
	Route::get('/welcome', ['as'=>'welcome','uses'=>'HomeController@index']);
	Route::get('/friendlist', ['as'=>'friendlist','uses'=>'HomeController@viewFriendlist']);
	Route::post('/welcome','HomeController@image');
	Route::get('add/{id}',['as'=>'add','uses'=>'HomeController@addFriend']);
	Route::get('/logout', 'HomeController@getLogout');
});
// admin
Route::group(['middleware' => ['web']], function () {
	Route::get('/admin', 'AdminController@getLogin');
	Route::post('/admin', 'AdminController@postLogin');
	Route::get('/dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);
});

Route::get('/home', 'HomeController@index')->name('home');

