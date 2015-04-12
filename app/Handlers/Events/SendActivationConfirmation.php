<?php namespace App\Handlers\Events;

use App\Events\AccountWasCreated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendActivationConfirmation {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  AccountWasCreated  $event
	 * @return void
	 */
	public function handle(AccountWasCreated $event)
	{
        \Mail::send('emails.confirmation', ['name' => $event->user->name, 'user_photo' => $event->user->user_photo, 'token' => $event->token] , function($message) use ($event)
        {
            $message->to($event->email)->subject('Confirmation');
        });
	}

}
