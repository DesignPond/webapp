<?php namespace App\Riiingme\Activite\Worker;

use App\Riiingme\Activite\Repo\ChangeInterface;
use App\Riiingme\Activite\Repo\RevisionInterface;
use App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer;
use App\Riiingme\User\Repo\UserInterface;

class ChangeWorker{

    protected $activite;
    protected $invite;
    protected $user;
    protected $label;

    public function __construct(ChangeInterface $change, UserInterface $user, RiiinglinkTransformer $label, RevisionInterface $revision){

        $this->changes  = $change;
        $this->user     = $user;
        $this->label    = $label;
        $this->revision = $revision;
    }

    /* *
     * Revision changes
    * */
    public function getLabelChanges($user_id, $period = null)
    {
        return $this->revision->getChanges($user_id, $period);
    }

    /* *
     * Partage changes
    * */
    public function getChangesConverted($user_id,$period){

        $changes = $this->getChanges($user_id,$period);
        $changes = $this->convertToLabels($changes,'added');

        return $changes;
    }

    public function getChanges($user_id,$period){

        $change = $this->changes->getUpdated($user_id,$period);

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

    public function getUsersHasUpdate($period)
    {
        $change   = $this->getUsersChange($period);
        $revision = $this->getUsersRevision($period);

        if(!empty($change) || !empty($revision))
        {
            return array_unique(array_merge($revision,$change));
        }

        return [];
    }

    public function getUsersRevision($period)
    {
        $revision = $this->revision->getUpdatedUser($period);

        return (!$revision->isEmpty() ? $revision->lists('user_id') : []);
    }

    public function getUsersChange($period)
    {
        $change = $this->changes->getAll($period);

        return (!$change->isEmpty() ? $change->lists('user_id') : []);
    }

    /**
     * Which = added or deleted
     * */
    public function convertToLabels($difference,$which)
    {
        if(isset($difference[$which]) && !empty($difference[$which]))
        {
            $data[$which] = $this->label->getLabels($difference[$which]);

            return $data;
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