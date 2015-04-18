<?php namespace App\Handlers\Events;

use App\Events\CheckChanges;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CheckChangesForUser {

    public $changes;
    public $type;

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->changes = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');
        $this->type    = \App::make('App\Riiingme\Type\Repo\TypeInterface');
	}

	/**
	 * Handle the event.
	 *
	 * @param  AccountWasCreated  $event
	 * @return void
	 */
	public function handle(CheckChanges $event)
	{
        $types    = $this->type->getAll()->lists('titre','id');
        $changes  = $this->changes->getChanges($event->user->id);

        if(!empty($changes))
        {
            \Mail::send('emails.changement', ['name' => $event->user->name, 'user_photo' => $event->user->user_photo, 'types' => $types , 'changes' => $changes] , function($message) use ($event)
            {
                $message->to($event->email)->subject('Notification de changement des données partagées');
            });
        }

    /*
        echo '<pre>';
        print_r($change);
        echo '</pre>';exit;
    */

	}

}
