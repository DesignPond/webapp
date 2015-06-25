<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendEmail extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

    protected $invited_id;
    protected $user;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($invited_id)
	{
        $this->user = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->invited_id = $invited_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $user = $this->user->find($this->invited_id);

        \Mail::later(120, 'emails.welcome', ['user' => $user], function($message)
        {
            $message->to('cindy.leschaud@gmail.com', 'Cindy Leschaud')->subject('Welcome!');
        });
	}

}
