<?php namespace App\Handlers\Events;

use App\Events\CheckChanges;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CheckChangesForUser {

    public $changes;
    public $type;
    public $user;

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->changes = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');
        $this->type    = \App::make('App\Riiingme\Type\Repo\TypeInterface');
        $this->user    = \App::make('App\Riiingme\User\Repo\UserInterface');
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
        $user     = $this->user->find($event->user->id);

        if(!empty($changes))
        {
            \Mail::send('emails.changement', ['user' => $user, 'types' => $types , 'changes' => $changes] , function($message) use ($event)
            {
                $message->to($event->user->email)->subject('Notification de changement des données partagées');
            });
        }

    /*
        echo '<pre>';
        print_r($change);
        echo '</pre>';exit;
    */

	}

}
