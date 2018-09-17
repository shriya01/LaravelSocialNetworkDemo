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

Route::get('/', 'UserController@index');
// user
Route::group(['middleware' => ['auth']], function () {
    Route::get('/welcome', ['as'=>'welcome','uses'=>'HomeController@index']);
    Route::get('/friendlist', ['as'=>'friendlist','uses'=>'HomeController@viewFriendlist']);
    Route::get('/friendrequests', ['as'=>'friendlist','uses'=>'HomeController@viewFriendRequests']);
    Route::post('/welcome', 'HomeController@image');
    Route::get('add/{id}', ['as'=>'add','uses'=>'HomeController@addFriend']);
    Route::get('cancel/{id}', ['as'=>'cancel','uses'=>'HomeController@cancelFriendRequest']);
    Route::get('confirm/{id}', ['as'=>'confirm','uses'=>'HomeController@confirmFriend']);
    Route::get('reject/{id}', ['as'=>'reject','uses'=>'HomeController@rejectFriendRequest']);
    Route::get('/friends', ['as'=>'friends','uses'=>'HomeController@Friendslist']);
    Route::get('/logout', 'HomeController@getLogout');
});
// admin
Route::group(['middleware' => ['web']], function () {
    Route::get('/admin', 'AdminController@getLogin');
    Route::post('/admin', 'AdminController@postLogin');
    Route::get('/dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);
    Route::get('/users', ['as'=>'users','uses'=>'DashboardController@users']);
});
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['web','guest']], function () {

// Register Routes
Route::get('/register', 'Auth\RegisterController@getRegister');
Route::post('/register', 'Auth\RegisterController@postRegister');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

// Login Routes
Route::get('/login',['as' => 'login', 'uses'=>'Auth\LoginController@getLogin']);
Route::post('/login','Auth\LoginController@postLogin');


});
// Logout Route

Route::get('/logout', 'HomeController@getLogout');
