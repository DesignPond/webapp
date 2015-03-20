<?php namespace App\Hub\Riiinme\User\Worker;

use App\Riiingme\User\Repo\UserInterface;

class UserWorker{

    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }



}