<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Queue;

class SendEmail extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

    protected $invited_id;
    protected $host_id;
    protected $user;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($host_id,$invited_id)
	{
        $this->user = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->invited_id = $invited_id;
        $this->host_id    = $host_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        $host    = $this->user->find($this->host_id);
        $invited = $this->user->find($this->invited_id);

        $user_name  = $invited->name;
        $user_photo = $invited->user_photo;

        $host_email = $host->email;
        $host_name  = $host->name;

       \Mail::later(180, 'emails.welcome', ['user_photo' => $user_photo, 'user_name' => $user_name], function($message) use ($host_email,$host_name)
        {
            //$message->to($host_email, $host_name)->subject('RiiingMe!');
            $message->to('cindy.leschaud@gmail.com', $host_name)->subject('RiiingMe!');
        });

	}

}
