<?php


Route::get('userlabels', 'HomeController@index');

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
/*    $ring   = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
    $meta   = \App::make('App\Riiingme\Meta\Entities\Meta');
    $meta   = $meta->find(1);
    $labels = $meta->labels;

    $this->command = new App\Commands\ProcessInvite(1);
    $link   = $this->command->getRiiinglink(1,2);*/
    //$invite =  $this->command->getInvite();
   // $metas  =  $this->command->convertMetasToLabels($link,unserialize($invite->partage_host));
    //$this->command->syncLabels($link);
    //$new = $ring->find($link->id)->first();
    echo '<pre>';
    //print_r(unserialize($new->usermetas->labels));
    echo '</pre>';
    //$link2   = $this->command->getRiiinglink(2,1);
    //$invite2 =  $this->command->getInvite();
   // $metas2  =  $this->command->convertMetasToLabels($link2,unserialize($invite2->partage_host));
    //$this->command->syncLabels($link2);
    //$new2 = $ring->find(1)->first();

    $type   = \App::make('App\Riiingme\Type\Repo\TypeInterface');
    $groupe = \App::make('App\Riiingme\Groupe\Worker\GroupeWorker');

    $types    = $type->getAll()->lists('titre','id');
    $groupes  = $groupe->getGroupes();
    unset($groupes[1]);


    $send2 = \App::make('App\Riiingme\Activite\Worker\SendWorker');
    $send2->setInterval('month')->getUsers();
    $all_changes2 = $send2->send();

    echo '<pre>';
    echo 'Mois';
    print_r($all_changes2);
    echo '</pre>';


    $send = \App::make('App\Riiingme\Activite\Worker\SendWorker');
    $send->setInterval('week')->getUsers();
    $all_changes = $send->send();

    echo '<pre>';
    echo 'Week';
    print_r($all_changes);
    echo '</pre>';

    $send1 = \App::make('App\Riiingme\Activite\Worker\SendWorker');
    $send1->setInterval('day')->getUsers();
    $all_changes = $send1->send();

    echo '<pre>';
    echo 'Day';
    print_r($all_changes);
    echo '</pre>';

/*
    if(!empty($all_changes))
    {
        foreach ($all_changes as $user)
        {
            \Mail::send('emails.changement', array('types' => $types, 'groupes_titres' => $groupes, 'data' => $user['invite']) , function($message) use ($user)
            {
                $message->to($user['email'])->subject('Notification de changement du partage');
            });
        }
    }*/

    
/*    $riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');

    $user        = \App::make('App\Riiingme\User\Repo\UserInterface');*/

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
    
    $change->setUser($user->id)->setPeriod($user->notification_interval);
    $data = $change->setUser(1)->setPeriod('week')->allChanges();

    $send = \App::make('App\Riiingme\Activite\Worker\SendWorker');

    $send->setInterval('week')->getUsers();
    $all_changes = $send->send();
   
/*echo '<pre>';
print_r($data);
echo '</pre>';exit;*/

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

Route::get('changes', function()
{
/*    $change = \App::make('App\Riiingme\Activite\Repo\RevisionInterface');

    $changes = $change->changes(1, 'day');

    echo '<pre>';
    print_r($changes->toArray());
    echo '</pre>';*/

    $change = \App::make('App\Riiingme\Activite\Repo\ChangeInterface');

    $changes = $change->getUserLastUpdates(1,1009);

    echo '<pre>';
    print_r($changes->toArray());
    echo '</pre>';


});

Route::get('notification', function()
{
    $user = \App::make('App\Riiingme\User\Entities\User');
    $user = $user->find(1);

    return View::make('emails.confirmation', array('user' => $user, 'user_photo' => 'avatar.jpg', 'name' => 'Cindy Leschaud', 'token' => '2rw3t342t2t'));
});

Route::get('sendEmail', function()
{
    $send = new App\Commands\SendEmail(2);

    $send->handle();

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