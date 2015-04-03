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
    Route::post('activites', array('as' => 'labels', 'uses' => 'UserController@activites'));

    // Upload
    Route::post('upload', array('as' => 'upload', 'uses' => 'UploadController@updatePhoto'));

    // Search
    Route::get('search', array('as' => 'search', 'uses' => 'SearchController@search'));

    // User
    Route::get('user/link/{id}', array('as' => 'show', 'uses' => 'UserController@link'));
    Route::get('user/partage', array('as' => 'partage', 'uses' => 'UserController@partage'));
    Route::get('user/timeline', array('as' => 'partage', 'uses' => 'UserController@timeline'));
    Route::get('user/message', array('as' => 'message', 'uses' => 'UserController@message'));
    Route::post('user/labels', array('as' => 'labels', 'uses' => 'UserController@labels'));

    Route::resource('user', 'UserController');

});


Route::group(['namespace' => 'Auth','prefix' => 'auth'], function()
{
    Route::get('register_company', array('as' => 'register_company', 'uses' => 'AuthController@register_company'));
    Route::get('register_private', array('as' => 'register_private', 'uses' => 'AuthController@register_private'));
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

    $user = \App::make('App\Riiingme\Riiinglink\Entities\Riiinglink');
    $user = $user->find(1);

    $meta = \App::make('App\Riiingme\Meta\Entities\Meta');
    $meta = $meta->find(1);
    $labels = $meta->first()->labels;

    echo '<pre>';
    print_r(unserialize($labels));
    echo '</pre>';

});

Event::listen('illuminate.query', function($query, $bindings, $time, $name)
{
    $data = compact('bindings', 'time', 'name');
// Format binding data for sql insertion
    foreach ($bindings as $i => $binding)
    {
        if ($binding instanceof \DateTime)
        {
            $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
        }
        else if (is_string($binding))
        {
            $bindings[$i] = "'$binding'";
        }
    }
// Insert bindings into query
    $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
    $query = vsprintf($query, $bindings);
    Log::info($query, $data);
});