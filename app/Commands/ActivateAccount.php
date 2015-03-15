<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Riiingme\User\Repo\UserInterface;

class ActivateAccount extends Command implements SelfHandling {

    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

	}

}
