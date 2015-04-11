<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class ActivateAccount extends Command implements SelfHandling {

    protected $user;
    protected $token;

    public function __construct($token)
    {
        $this->user  = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->token = $token;
    }

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        //$this->user->activate($this->token);

        dd('activated!!');
	}

}
