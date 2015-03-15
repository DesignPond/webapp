<?php namespace Riiingme\Command;

class CreateRiiinglinkCommand {

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $invite;

    /**
     * @param string token
     * @param string ref
     */
    public function __construct($user, $invite)
    {
        $this->user   = $user;
        $this->invite = $invite;
    }

}