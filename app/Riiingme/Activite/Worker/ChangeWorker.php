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

        if( $change->count() > 1)
        {
            $newChanges = $change->first();
            $oldChanges = $change->last();

            $newLabels = (!empty($newChanges->labels) ? unserialize($newChanges->labels) : []);
            $oldLabels = (!empty($oldChanges->labels) ? unserialize($oldChanges->labels) : []);

            $difference = $this->calculDiff($oldLabels, $newLabels);

            return $difference;
        }

        return [];

    }

    public function calculDiff($oldLabels,$newLabels)
    {

        $all_groupes = range(1,6);

        foreach($all_groupes as $group_id)
        {
            if( isset($newLabels[$group_id]) && isset($oldLabels[$group_id]) )
            {
                $deleted = array_diff($oldLabels[$group_id], $newLabels[$group_id]);

                if(!empty($deleted)){
                    $difference['deleted'][$group_id] = $deleted;
                }

                $added = array_diff($newLabels[$group_id],$oldLabels[$group_id]);

                if(!empty($added)){
                    $difference['added'][$group_id] = $added;
                }

            }

            elseif( isset($newLabels[$group_id]) && !isset($oldLabels[$group_id]) )
            {
               $difference['added'][$group_id] = $newLabels[$group_id];
            }

            elseif( !isset($newLabels[$group_id]) && isset($oldLabels[$group_id]) )
            {
                $difference['added'][$group_id] = $oldLabels[$group_id];
            }
        }

        return $difference;
    }

}