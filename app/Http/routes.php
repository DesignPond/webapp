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
    Route::get('sendActivationLink', array('as' => 'send', 'uses' => 'DispatchController@sendActivationLink'));

    // Ajax
    Route::get('riiinglinks', array('as' => 'riiinglinks', 'uses' => 'RiiinglinkController@index'));
    Route::get('total', array('as' => 'total', 'uses' => 'RiiinglinkController@total'));
    Route::post('updateMetas', 'MetasController@update');

    Route::post('activites', array('as' => 'activites', 'uses' => 'ActiviteController@activites'));

    // Upload
    Route::post('upload', array('as' => 'upload', 'uses' => 'UploadController@updatePhoto'));

    // Search
    Route::get('search', array('as' => 'search', 'uses' => 'SearchController@search'));

    // Tags, Ajax
    Route::get('tags', 'TagController@tags');
    Route::get('allTags', 'TagController@allTags');
    Route::post('addTag', 'TagController@addTag');
    Route::post('removeTag', 'TagController@removeTag');

    // User
    Route::get('user/link/{id}', array('as' => 'show', 'uses' => 'RiiinglinkController@show'));
    Route::get('user/partage', array('as' => 'partage', 'uses' => 'ActiviteController@partage'));
    Route::get('user/timeline', array('as' => 'timeline', 'uses' => 'ActiviteController@index'));
    Route::get('user/message', array('as' => 'message', 'uses' => 'UserController@message'));
    Route::post('user/labels', array('as' => 'labels', 'uses' => 'UserController@labels'));
    Route::match(['get', 'post'],'user/{id}', array('as' => 'show', 'uses' => 'UserController@show'));
    Route::resource('user', 'UserController');

    Route::resource('export', 'ExportController');
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
   // return DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
   // $link = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
   // $ring = $link->create([ 'host_id' => 1, 'invited_id' => 23 ]);

/*
    $meta = \App::make('App\Riiingme\Meta\Entities\Meta');
    $meta = $meta->find(1);
    $labels = $meta->first()->labels;
*/
    $user = \App::make('App\Riiingme\User\Repo\UserInterface');
    $user = $user->find(\Auth::user()->id);

   // \Event::fire(new \App\Events\AccountWasCreated($user,$user->activation_token));
    //throw new \App\Exceptions\ActivationFailException(1,'2w3eg24t2t');
   // $changes = \App::make('App\Riiingme\Activite\Repo\ChangeInterface');
    //$change  = $changes->getAll(25);

    // \Event::fire(new \App\Events\AccountWasCreated($user,$user->activation_token));
    //throw new \App\Exceptions\ActivationFailException(1,'2w3eg24t2t');

    \Event::fire(new \App\Events\CheckChanges($user));

});

Route::get('changement', function()
{

    $user  = \App::make('App\Riiingme\User\Entities\User');
    $type  = \App::make('App\Riiingme\Type\Repo\TypeInterface');
    $user  = $user->find(1);
    $types = $type->getAll()->lists('titre','id');

    $changes = [
        'added'   => [
            2 => [ 1 => 2,  4 => 3, 5 => 4 ],
            3 => [ 1 => 11]
        ],
        'deleted' => [
            3 =>  [ 3 => 13,  7 => 17 ]
        ]
    ];

    return View::make('emails.changement', array('user' => $user, 'user_photo' => 'avatar.jpg', 'types' => $types , 'name' => 'Cindy Leschaud', 'changes' => $changes));

});

Route::get('notification', function()
{
    $user = \App::make('App\Riiingme\User\Entities\User');
    $user = $user->find(1);

    return View::make('emails.confirmation', array('user' => $user, 'user_photo' => 'avatar.jpg', 'name' => 'Cindy Leschaud', 'token' => '2rw3t342t2t'));
});

Route::get('invitation', function()
{
    $user   = \App::make('App\Riiingme\User\Entities\User');
    $invite = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
    $invite = $invite->find(3);
    $user   = $user->find($invite->user_id);
    $data   = array('invite' => $invite, 'user' => $user, 'types' => [], 'partage' => []);

    return View::make('emails.invitation', $data);
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