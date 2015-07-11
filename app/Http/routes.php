<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', array('as' => 'home', 'uses' => 'WelcomeController@index'));

Route::get('activation', array('as' => 'activation', 'uses' => 'DispatchController@activation'));
Route::get('invite', array('as' => 'invite', 'uses' => 'DispatchController@invite'));
Route::get('sendActivationLink', array('as' => 'send', 'uses' => 'DispatchController@sendActivationLink'));

Route::group(['middleware' => ['auth','activate']], function()
{
    Route::post('send', array('as' => 'send', 'uses' => 'DispatchController@send'));
    Route::get('labels', array('as' => 'labels', 'uses' => 'ActiviteController@labels'));

    // Ajax
    Route::get('riiinglinks', array('as' => 'riiinglinks', 'uses' => 'RiiinglinkController@index'));
    Route::get('destroyLink/{id}', array('as' => 'destroyLink', 'uses' => 'RiiinglinkController@destroy'));
    Route::get('total', array('as' => 'total', 'uses' => 'RiiinglinkController@total'));

    Route::post('updateMetas', 'MetasController@update');
    Route::post('updatePeriod', 'MetasController@updatePeriod');

    Route::post('activites', array('as' => 'activites', 'uses' => 'ActiviteController@activites'));

    // Upload
    Route::post('upload', array('as' => 'upload', 'uses' => 'UploadController@updatePhoto'));

    // Search
    Route::get('search', array('as' => 'search', 'uses' => 'SearchController@search'));

    // User
    Route::match(['get', 'post'],'user', array('as' => 'show', 'uses' => 'UserController@index'));
    Route::get('user/{id}/edit', array('as' => 'edit', 'uses' => 'UserController@edit'));
    Route::get('user/message', array('as' => 'message', 'uses' => 'UserController@message'));
    Route::get('user/activites', array('as' => 'lastactivites', 'uses' => 'UserController@activites'));
    Route::post('user/labels', array('as' => 'labels', 'uses' => 'UserController@labels'));
    Route::delete('user/{id}', array('as' => 'destroy', 'uses' => 'UserController@destroy'));

    //Route::resource('user', 'UserController');

    // Riiinglinks
    Route::get('user/link/{id}', array('as' => 'show', 'uses' => 'RiiinglinkController@show'));

    // Activites
    Route::get('user/partage/{with?}', array('as' => 'partage', 'uses' => 'ActiviteController@partage'));
    Route::get('user/timeline', array('as' => 'timeline', 'uses' => 'ActiviteController@index'));

    // Tags, Ajax routes
    Route::get('tags', 'TagController@tags');
    Route::get('allTags', 'TagController@allTags');
    Route::post('addTag', 'TagController@addTag');
    Route::post('removeTag', 'TagController@removeTag');

    // Export routes
    Route::resource('export', 'ExportController');
    Route::post('export/contacts', array('as' => 'contacts', 'uses' => 'ExportController@contacts'));
    Route::post('export/generate', array('as' => 'generate', 'uses' => 'ExportController@generate'));
    Route::get('exportLabels', array('as' => 'exportLabels', 'uses' => 'ExportController@exportLabels'));

    Route::resource('change', 'ChangeController');
});

Route::group(['namespace' => 'Auth','prefix' => 'auth'], function()
{
    Route::get('register_company', array('as' => 'register_company', 'uses' => 'AuthController@register_company'));
    Route::get('register_private', array('as' => 'register_private', 'uses' => 'AuthController@register_private'));
    Route::get('activate', array('as' => 'activate', 'uses' => 'AuthController@activate'));
});

Route::controllers([
	'auth'     => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);

Route::get('logout', function()
{
    Auth::logout();
    Session::flush();
    return Redirect::to('/');
});

/*
 * Languages
 * */
Route::get('/setlang/{lang}', function($lang)
{
    \Session::put('locale', $lang);

    return Redirect::back();
});

/*
 * Only for development
 * */
require app_path().'/Http/dev.php';