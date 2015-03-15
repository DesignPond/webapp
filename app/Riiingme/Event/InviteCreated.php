<?php namespace Riiingme\Event;

use Riiingme\Invite\Entities\Invite;

class InviteCreated {

    public $invite;

    public function __construct(Invite $invite) /* or pass in just the relevant fields */
    {
        $this->invite = $invite;
    }

}