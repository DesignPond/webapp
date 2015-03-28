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

Route::group(['middleware' => 'auth'], function()
{
    Route::post('send', array('as' => 'send', 'uses' => 'DispatchController@send'));

    // Ajax
    Route::get('riiinglinks', array('as' => 'riiinglinks', 'uses' => 'RiiinglinkController@index'));
    Route::get('total', array('as' => 'total', 'uses' => 'RiiinglinkController@total'));
    Route::post('updateMetas', 'MetasController@updateMetas');
    // Upload
    Route::post('upload', array('as' => 'upload', 'uses' => 'UploadController@updatePhoto'));

    // Search
    Route::get('search', array('as' => 'search', 'uses' => 'SearchController@search'));

    // User
    Route::get('user/link/{id}', array('as' => 'show', 'uses' => 'UserController@link'));
    Route::get('user/partage', array('as' => 'partage', 'uses' => 'UserController@partage'));
    Route::get('user/message', array('as' => 'message', 'uses' => 'UserController@message'));
    Route::post('user/labels', array('as' => 'labels', 'uses' => 'UserController@labels'));

    Route::resource('user', 'UserController');

});


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

Route::get('test', function()
{
    //return DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;

   // $link = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
   // $ring = $link->create([ 'host_id' => 1, 'invited_id' => 23 ]);

    $user = \App::make('App\Riiingme\User\Repo\UserInterface');
    $user = $user->find(1);

    echo '<pre>';
    print_r($user->activites()->with('invitation')->get()->toArray());
    echo '</pre>';

});
