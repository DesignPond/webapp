<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class CheckChanges extends Event {

	use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

}
