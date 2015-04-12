<?php namespace App\Handlers\Events;

use App\Events\AccountWasCreated;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use App\Commands\ProcessInvite;

class ProcessInvitation {

    use DispatchesCommands;

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Handle the event.
	 *
	 * @param  AccountWasCreated  $event
	 * @return void
	 */
	public function handle(AccountWasCreated $event)
	{
        if($event->invite_id)
        {
            $this->dispatch(new ProcessInvite($event->invite_id));
        }
	}

}
