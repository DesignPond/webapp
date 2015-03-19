<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', array('as' => 'home', 'uses' => 'WelcomeController@index'));
Route::get('about', array('as' => 'about', 'uses' => 'WelcomeController@about'));
Route::get('contact', array('as' => 'contact', 'uses' => 'WelcomeController@contact'));

Route::get('activation', array('as' => 'activation', 'uses' => 'DispatchController@activation'));
Route::get('invite', array('as' => 'invite', 'uses' => 'DispatchController@invite'));
Route::post('send', array('as' => 'send', 'uses' => 'DispatchController@send'));
// Ajax
Route::get('riiinglinks', array('as' => 'riiinglinks', 'uses' => 'RiiinglinkController@index'));
Route::get('total', array('as' => 'total', 'uses' => 'RiiinglinkController@total'));

// Upload
Route::post('upload', array('as' => 'upload', 'uses' => 'UploadController@upload'));

// User
Route::get('user/link/{id}', array('as' => 'show', 'uses' => 'UserController@link'));
Route::get('user/partage', array('as' => 'partage', 'uses' => 'UserController@partage'));
Route::get('user/message', array('as' => 'message', 'uses' => 'UserController@message'));
Route::post('user/labels', array('as' => 'labels', 'uses' => 'UserController@labels'));

Route::resource('user', 'UserController');

// Search
Route::get('search', array('as' => 'search', 'uses' => 'SearchController@search'));

Route::controllers([
	'auth'     => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('logout', function()
{
    Auth::logout();
    Session::flush();
    return Redirect::to('/');

});