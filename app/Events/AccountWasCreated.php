<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class AccountWasCreated extends Event {

	use SerializesModels;

    public $user;
    public $email;
    public $activation_token;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($user,$activation_token)
	{
		$this->user   = $user;
        $this->email  = $user->email;
        $this->token =  $activation_token;
	}

}
