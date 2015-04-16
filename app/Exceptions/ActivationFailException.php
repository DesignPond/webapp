<?php namespace App\Exceptions;

class ActivationFailException extends \Exception {

    public $token;

    function __construct($token)
    {
        $this->token   = $token;
    }

    function getToken()
    {
        return $this->token;
    }
}
