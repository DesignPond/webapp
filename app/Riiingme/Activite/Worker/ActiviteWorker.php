<?php namespace App\Riiingme\Activite\Worker;

use App\Riiingme\Activite\Repo\ActiviteInterface;
use App\Riiingme\User\Repo\UserInterface;

class ActiviteWorker{

    protected $activite;
    protected $user;

    public function __construct(ActiviteInterface $activite, UserInterface $user){

        $this->activite = $activite;
        $this->user = $user;
    }

    public function getActivites($user_id){


        $user = $this->user->find($user_id);

        $activites   = $user->invitations()->with('host')->get()->take(3);
        $invitations = $user->activites()->with('invitation')->get()->take(3);

        $result = $activites->merge($invitations);

        $result->sortByDesc('updated_at');

        return $result;

    }


}