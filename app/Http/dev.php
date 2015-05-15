<?php

Route::get('test', function()
{
    // return DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
    // $link = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
    // $ring = $link->create([ 'host_id' => 1, 'invited_id' => 23 ]);
    //throw new Illuminate\Session\TokenMismatchException;
    /*


       $invite = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
       $invite = $invite->find(1);

          $change      = \App::make('App\Riiingme\Activite\Repo\ChangeInterface');

       $tags        = \App::make('App\Riiingme\Tag\Repo\TagInterface');

      */
    $meta   = \App::make('App\Riiingme\Meta\Entities\Meta');
    $meta   = $meta->find(1);
    $labels = $meta->labels;
    
    echo '<pre>';
    print_r(unserialize($labels));
    echo '</pre>';exit;
    
    $riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
    $change      = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');
    $user        = \App::make('App\Riiingme\User\Repo\UserInterface');

   // $change = $change->getLabelChange(1);

    //$riiinglinks = $riiinglink->findByHost(1)->lists('id');
    //$results     = $riiinglink->findTags(4,$riiinglinks);

/*    $thsuer = $user->find(1);
    
    echo '<pre>';
    print_r($thsuer->load('riiinglinks')->riiinglinks->lists('invited_id'));
    echo '</pre>';exit;*/

    // \Event::fire(new \App\Events\AccountWasCreated($user,$user->activation_token));
    //throw new \App\Exceptions\ActivationFailException(1,'2w3eg24t2t');
    // $changes = \App::make('App\Riiingme\Activite\Repo\ChangeInterface');
    //$change  = $changes->getAll(25);

    // \Event::fire(new \App\Events\AccountWasCreated($user,$user->activation_token));
    //throw new \App\Exceptions\ActivationFailException(1,'2w3eg24t2t');

   // \Event::fire(new \App\Events\CheckChanges($user));

});

Route::get('changement', function()
{

    $users  = \App::make('App\Riiingme\User\Repo\UserInterface');
    $type   = \App::make('App\Riiingme\Type\Repo\TypeInterface');
    $groupe = \App::make('App\Riiingme\Groupe\Worker\GroupeWorker');
    $change = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');

    $types  = $type->getAll()->lists('titre','id');
    $user   = $users->find(1);

    $groupes = $groupe->getGroupes();
    unset($groupes[1]);

    /*
    $change->setUser($user->id)->setPeriod($user->notification_interval);
    $data = $change->allChanges();
    */

    // Load user riiinglinks to get all invited
    $invited = $user->load('riiinglinks')->riiinglinks->lists('invited_id');

    if(!empty($invited))
    {
        $data = [];

        foreach ($invited as $invite)
        {
            $changes = $change->setUser($invite)->setPeriod($user->notification_interval)->allChanges();

            if (!empty($changes))
            {
                $data[$invite] = $changes;
                $data[$invite]['user'] = $users->simpleFind($invite);
            }
        }

        return View::make('emails.changement', array('types' => $types , 'groupes_titres' => $groupes, 'data' => $data));
    }


/*    $changes = [
        'added'   => [
            2 => [ 1 => 2,  4 => 3, 5 => 4 ],
            3 => [ 1 => 11]
        ],
        'deleted' => [
            3 =>  [ 3 => 13,  7 => 17 ]
        ]
    ];*/



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
    $invite = $invite->find(1);
    $user   = $user->where('id','=',$invite->user_id)->with('labels')->get()->first();
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