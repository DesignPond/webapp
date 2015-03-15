<?php namespace Riiingme\Command;

class CreateUserCommand {

    public $email;

    public $first_name;

    public $last_name;

    public $company;

    public $invite_id;

    public $user_type;

    public $password;

    public $password_confirmation;

    public function __construct($email, $first_name, $last_name, $company, $invite_id, $user_type, $password, $password_confirmation)
    {
        $this->email                 = $email;
        $this->first_name            = $first_name;
        $this->last_name             = $last_name;
        $this->company               = $company;
        $this->invite_id             = $invite_id;
        $this->user_type             = $user_type;
        $this->password              = $password;
        $this->password_confirmation = $password_confirmation;
    }

}