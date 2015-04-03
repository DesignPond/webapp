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

        $activites   = $user->invitations()->with('host')->orderBy('created_at', 'desc')->get();
        $invitations = $user->activites()->with('invited')->orderBy('created_at', 'desc')->get();

        $result = $activites->merge($invitations);
        $result->sortByDesc('created_at');

        return $result;

    }

    public function getTotal($user_id){

        return $this->getActivites($user_id)->count();
    }

    public function getPendingInvites($user_id){

        $user = $this->user->find($user_id);
        $invitations = $user->activites()->with('invite')->where('invited_id','=',null)->get();
        $invitations->sortByDesc('created_at');

        return $invitations;
    }

    public function getPaginate($user_id, $skip, $take){

        $activites = $this->getActivites($user_id);
        $activites = $activites->slice($skip, $take);

        return $activites;
    }

}