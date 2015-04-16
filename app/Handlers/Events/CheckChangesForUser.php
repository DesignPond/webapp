<?php namespace App\Handlers\Events;

use App\Events\CheckChanges;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CheckChangesForUser {

    public $changes;

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->changes = \App::make('App\Riiingme\Activite\Repo\ChangeInterface');
	}

	/**
	 * Handle the event.
	 *
	 * @param  AccountWasCreated  $event
	 * @return void
	 */
	public function handle(CheckChanges $event)
	{
        /*
        \Mail::send('emails.confirmation', ['name' => $event->user->name, 'user_photo' => $event->user->user_photo, 'token' => $event->token] , function($message) use ($event)
        {
            $message->to($event->email)->subject('Confirmation');
        });
        */

        //$event->user

        $change  = $this->changes->getAll($event->user->id);

        // \Event::fire(new \App\Events\AccountWasCreated($user,$user->activation_token));
        //throw new \App\Exceptions\ActivationFailException(1,'2w3eg24t2t');
        dd($change);
	}

}
