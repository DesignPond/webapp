<?php namespace App\Riiingme\Activite\Worker;

use App\Riiingme\Activite\Repo\ChangeInterface;
use App\Riiingme\User\Repo\UserInterface;

class ChangeWorker{

    protected $activite;
    protected $invite;
    protected $user;

    public function __construct(ChangeInterface $change, UserInterface $user){

        $this->changes = $change;
        $this->user    = $user;
    }

    public function getChanges($user_id){

        $change = $this->changes->getUpdated($user_id);

        if( $change->count() > 1){

            $newChanges = $change->first();
            $oldChanges = $change->last();

            $newLabels = (!empty($newChanges->labels) ? unserialize($newChanges->labels) : []);
            $oldLabels = (!empty($oldChanges->labels) ? unserialize($oldChanges->labels) : []);

            $difference = array_diff($oldLabels, $newLabels);

            return $difference;
        }

    }

    public function calculDiff($oldLabels,$newLabels)
    {

        foreach($oldLabels as $group_id => $groupes)
        {
            if(isset($newLabels[$group_id]))
            {
                $difference = array_diff($oldLabels[$group_id], $newLabels[$group_id]);
            }
            else
            {
                if(isset($exist[$group_id]))
                {
                    $data[$group_id] = $exist[$group_id];
                    ksort($data[$group_id]);
                }
            }
        }

    }

}