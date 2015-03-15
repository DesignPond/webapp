<?php namespace Riiingme\User\Event;

use  Riiingme\User\Entities\User;

class UserWasCreated{

    public $user;
    public $email;
    public $first_name;
    public $last_name;
    public $activation_token;

    public function __construct(User $user) /* or pass in just the relevant fields */
    {
        $this->user  = $user;
        $this->email = $user->email;
        $this->first_name = $user->first_name;
        $this->last_name  = $user->last_name;
        $this->activation_token = $user->activation_token;
    }
}