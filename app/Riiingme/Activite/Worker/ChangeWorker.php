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
    protected $groupes;

    public $user_id;
    public $period;

    public function __construct(ChangeInterface $change, UserInterface $user, RiiinglinkTransformer $label, RevisionInterface $revision){

        $this->changes  = $change;
        $this->user     = $user;
        $this->label    = $label;
        $this->revision = $revision;

        $this->groupes = range(1,6);
        $this->period  = 'semester';
    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /* *
     * Revision changes
    * */
    public function getLabelChanges()
    {
        return $this->revision->changes($this->user_id, $this->period);
    }

    /* *
     * Partage changes
    * */
    public function getChangesConverted()
    {
        return $this->convertToLabels($this->getChanges(),'added');
    }

    public function getChanges(){

        $change = $this->changes->getUpdated($this->user_id, $this->period);

        if( $change->count() > 1)
        {

            $difference = $this->calculDiff(unserialize($change->last()->labels), unserialize($change->first()->labels));

            return $difference;
        }

        return [];

    }

    public function getUsersHasUpdate()
    {
        $change   = $this->getUsersChange($this->period);
        $revision = $this->getUsersRevision($this->period);

        return array_unique(array_merge($revision,$change));
    }


    public function getUsersRevision()
    {
        return $this->revision->getUpdatedUser($this->period)->lists('user_id');
    }

    public function getUsersChange()
    {
        return $this->changes->getAll($this->period)->lists('user_id');
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

        foreach($this->groupes as $group_id)
        {
            if( (isset($newLabels[$group_id]) ) && isset($oldLabels[$group_id]) )
            {
                $deleted = array_diff($oldLabels[$group_id], $newLabels[$group_id]);

                if(!empty($deleted))  $difference['deleted'][$group_id] = $deleted;

                $added = array_diff($newLabels[$group_id],$oldLabels[$group_id]);

                if(!empty($added)) $difference['added'][$group_id] = $added;
            }

            if( isset($newLabels[$group_id]) && !isset($oldLabels[$group_id]) ) $difference['added'][$group_id] = $newLabels[$group_id];
            if( !isset($newLabels[$group_id]) && isset($oldLabels[$group_id]) ) $difference['added'][$group_id] = $oldLabels[$group_id];

        }

        return $difference;
    }

}