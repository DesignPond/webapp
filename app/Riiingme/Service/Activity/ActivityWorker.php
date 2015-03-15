<?php namespace App\Riiingme\Service\Activity;

use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Invite\Repo\InviteInterface;

class ActivityWorker{

    protected $riiinglink;
    protected $invite;

    public function __construct(RiiinglinkInterface $riiinglink,InviteInterface $invite){

        $this->invite     = $invite;
        $this->riiinglink = $riiinglink;

    }

    public function getInvites($user_id){

        return $this->invite->getAll($user_id);
    }


    public function getActivity($user_id){

        $activity = [];

        $invites   = $this->invite->getAll($user_id);
        $ringlinks = $this->riiinglink->findByHost($user_id);

        if(!$invites->isEmpty()){
            foreach($invites as $invite)
            {
                $activity[$invite->created_at->timestamp] = $invite;
            }
        }

        ksort($activity);

        $activity = $this->sortActivity($activity);

        return $activity;

    }

    public function sortActivity($list){

        $activity = [];

        if(!empty($list))
        {
            foreach($list as $event)
            {
                $activity[$event->id]['type']  = 'invite';
                $activity[$event->id]['event'] = $event;
            }
        }

        return $activity;
    }

}