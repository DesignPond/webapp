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
    public $updates;
    public $part;

    public function __construct(ChangeInterface $change, UserInterface $user, RiiinglinkTransformer $label, RevisionInterface $revision){

        $this->changes  = $change;
        $this->user     = $user;
        $this->label    = $label;
        $this->revision = $revision;

        $this->groupes = range(1,6);
        $this->period  = 'semester';
        $this->part    = 'added';
    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    public function setPart($part)
    {
        $this->part = $part;

        return $this;
    }

    /* *
     * Revision changes
    * */
    public function updates()
    {
        $this->updates = $this->changes->getUpdated($this->user_id, $this->period);

        return $this;
    }

    public function getLabelChanges()
    {
        return $this->revision->changes($this->user_id, $this->period);
    }

    /* *
     * Partage changes
    * */
    public function getChangesConverted()
    {
        return $this->convertToLabels($this->getChanges(),$this->part);
    }

    public function getChanges(){

        if( $this->updates->count() > 1)
        {
            return $this->calculDiff(unserialize($this->updates->last()->labels), unserialize($this->updates->first()->labels));
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
     * @return array difference
    * */
    public function convertToLabels($difference)
    {
        if( !empty($difference) && isset($difference[$this->part]) && !empty($difference[$this->part]) )
        {
            return $data[$this->part] = $this->label->getLabels($difference[$this->part]);
        }

        return [];
    }

    public function calculDiff($oldLabels,$newLabels)
    {

        $difference = [];

        foreach($this->groupes as $group_id)
        {
            if( (isset($newLabels[$group_id]) ) && isset($oldLabels[$group_id]) )
            {
                $deleted = array_diff($oldLabels[$group_id], $newLabels[$group_id]);

                if(!empty($deleted))
                    $difference['deleted'][$group_id] = $deleted;

                $added = array_diff($newLabels[$group_id],$oldLabels[$group_id]);

                if(!empty($added))
                    $difference['added'][$group_id] = $added;
            }

            if( isset($newLabels[$group_id]) && !isset($oldLabels[$group_id]) )
                $difference['added'][$group_id] = $newLabels[$group_id];

            if( !isset($newLabels[$group_id]) && isset($oldLabels[$group_id]) )
                $difference['deleted'][$group_id] = $oldLabels[$group_id];

        }

        return $difference;
    }

}