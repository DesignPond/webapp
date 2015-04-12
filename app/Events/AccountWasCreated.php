<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class AccountWasCreated extends Event {

	use SerializesModels;

    public $user;
    public $email;
    public $token;
    public $invite_id;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($user, $invite_id = null)
	{
		$this->user      = $user;
        $this->email     = $user->email;
        $this->token     = $user->activation_token;
        $this->invite_id = $invite_id;
	}

}
