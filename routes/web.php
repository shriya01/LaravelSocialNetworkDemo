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


Route::get('add/{id}', ['as'=>'add','uses'=>'UserController@addFriend']);
Route::get('confirm/{id}', ['as'=>'confirm','uses'=>'UserController@confirmFriendRequest']);
Route::get('reject/{id}', ['as'=>'reject','uses'=>'UserController@rejectFriendRequest']);
Route::get('remove', ['as'=>'remove','uses'=>'UserController@removeFriend']);
Route::get('block/{id}', ['as'=>'block','uses'=>'UserController@blockUser']);
Route::get('unblock/{id}', ['as'=>'unblock','uses'=>'UserController@unblockUser']);
Route::get('friendlist', ['as'=>'friendlist','uses'=>'UserController@getFriendList']);
Route::get('pendingrequests', ['as'=>'pendingrequests','uses'=>'UserController@showPendingRequests']);
Route::get('friendSuggestionList', ['as'=>'pendingrequests','uses'=>'UserController@friendSuggestionList']);

Route::get('cancel/{id}', ['as'=>'cancel','uses'=>'UserController@cancelFriendRequest']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');