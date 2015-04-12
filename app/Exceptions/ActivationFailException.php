<?php namespace App\Exceptions;

class ActivationFailException extends \Exception {

    public $token;
    public $user_id;

    function __construct($user_id,$token)
    {
        $this->token   = $token;
        $this->user_id = $user_id;
    }

    function getToken()
    {
        return $this->token;
    }

    function getUser()
    {
        return $this->user_id;
    }
}
