<?php namespace Riiingme\Listener;

use Laracasts\Commander\Events\EventListener;
use Riiingme\User\Event\UserWasCreated;

class EmailNotifier extends EventListener {

    public function whenUserWasCreated(UserWasCreated $event)
    {
       \Mail::send('emails.confirmation', array('token' => $event->activation_token), function($message) use ($event)
        {
            $message->to($event->email, $event->email)->subject('Création de votre compte!');
        });
    }

}