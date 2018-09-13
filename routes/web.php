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


Route::get('add/{id}', ['as'=>'add','uses'=>'HomeController@addFriend']);
Route::get('confirm/{id}', ['as'=>'confirm','uses'=>'HomeController@confirmFriendRequest']);
Route::get('reject/{id}', ['as'=>'reject','uses'=>'HomeController@rejectFriendRequest']);
Route::get('remove', ['as'=>'remove','uses'=>'HomeController@removeFriend']);
Route::get('block/{id}', ['as'=>'block','uses'=>'HomeController@blockUser']);
Route::get('unblock/{id}', ['as'=>'unblock','uses'=>'HomeController@unblockUser']);
Route::get('friendlist', ['as'=>'friendlist','uses'=>'HomeController@getFriendList']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
