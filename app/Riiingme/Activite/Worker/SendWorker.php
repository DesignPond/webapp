<?php namespace App\Riiingme\Activite\Worker;

use App\Riiingme\Activite\Worker\ChangeWorker;
use App\Riiingme\User\Repo\UserInterface;

class SendWorker{

    protected $user;
    protected $change;

    public $interval;
    public $users;
    public $changeForInvite;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChangeWorker $change, UserInterface $user)
    {
        $this->changes  = $change;
        $this->user     = $user;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    public function send()
    {
        $data  = [];

        if(!empty( $this->users ))
        {
            foreach ($this->users as $user)
            {
                $invited = $user->riiinglinks->lists('invited_id');

                if(!$user->riiinglinks->isEmpty())
                {
                    foreach($user->riiinglinks as $invite)
                    {
                        $this->getChangesForInvite($invite);

                        if(!empty($this->changeForInvite))
                        {
                            $data[$user->id]['email'] = $user->email;
                            $data[$user->id]['invite'][$invite->invited_id] = $this->prepareChangeForinvite($invite,$user);
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function prepareChangeForInvite($invite)
    {
        $invited = $this->user->simpleFind($invite->invited_id);

        return  $this->changeForInvite  + ['user' => ['name' => $invited->name, 'photo' => $invited->user_photo]];
    }

    public function getChangesForInvite($riiinglink)
    {
        $this->changeForInvite = $this->changes->setRiiinglink($riiinglink)->setUser($riiinglink->invited_id)->setPeriod($this->interval)->allChanges();

        return $this;
    }

    public function getUsers()
    {
        $this->users = $this->user->getAll($this->interval);

        return $this;
    }

}