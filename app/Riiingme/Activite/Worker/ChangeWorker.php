<?php namespace App\Riiingme\Activite\Worker;

use App\Riiingme\Activite\Repo\ChangeInterface;
use App\Riiingme\Activite\Repo\RevisionInterface;
use App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer;
use App\Riiingme\Label\Worker\LabelWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Meta\Repo\MetaInterface;

class ChangeWorker{

    protected $activite;
    protected $invite;
    protected $user;
    protected $label;
    protected $groupes;
    protected $worker;
    protected $link;
    protected $converter1;
    protected $converter2;
    protected $meta;

    public $part   = 'added';
    public $period = 'semester';
    public $updates;
    public $user_id;
    public $invited;
    public $riiinglink;

    public function __construct(ChangeInterface $change, RiiinglinkInterface $link, LabelWorker $worker, UserInterface $user, RiiinglinkTransformer $label, RevisionInterface $revision, MetaInterface $meta){

        $this->changes    = $change;
        $this->user       = $user;
        $this->label      = $label;
        $this->worker     = $worker;
        $this->revision   = $revision;
        $this->link       = $link;
        $this->meta       = $meta;
        $this->groupes    = range(1,6);
        $this->converter1  = \App::make('App\Riiingme\Riiinglink\Worker\ConvertWorker');
        $this->converter2  = \App::make('App\Riiingme\Riiinglink\Worker\ConvertWorker');
    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;
        $this->invited = $this->user->find($user_id);

        return $this;
    }

    public function setRiiinglink($riiinglink)
    {
        $riiinglink = $this->link->findByHostAndInvited($riiinglink->invited_id,$riiinglink->host_id);

        $this->riiinglink = $riiinglink;

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

    public function allChanges()
    {
        $changes   = $this->updates()->getChangesConverted();
        $revisions = $this->getLabelChanges();

        $data = [];

        if(!empty($changes) || !$revisions->isEmpty())
        {
            if(!empty($changes))
            {
                $this->converter1->loadUserLabels($this->riiinglink,true)->prepareLabels();
                $this->converter1->metas = $changes;
                $this->converter1->convertChanges($changes);
                $this->converter1->metasInEffect();
                $this->converter1->convertPeriodRange();
                $this->converter1->labelsToShow();

                if(!empty($this->converter1->labels))
                {
                    $data['changes'] = $this->converter1->labels;
                }
            }

            if(!empty($revisions))
            {
                $items = [];

                foreach($revisions as $update)
                {
                    if(isset($update->label))
                    {
                        $items[$update->label->groupe_id][$update->label->type_id] = $update->new_value;
                    }
                }

                //$items = $this->worker->periodIsInEffect($this->invited->users_groups, $items);
                $this->converter2->loadUserLabels($this->riiinglink,true)->prepareLabels()->metasInEffect();
                $this->converter2->labels = $items;
                $this->converter2->convertPeriodRange()->labelsToShow();

                if(!empty($this->converter2->labels))
                {
                    $data['revision'] = $this->converter2->labels;
                }

            }
        }

        return $data;
    }

    /* *
     * Revision changes
    * */
    public function updates()
    {
        if(isset($this->riiinglink))
        {
            $this->updates = $this->changes->getUserUpdates($this->user_id, $this->riiinglink->id, $this->period);
        }

        return $this;
    }

    public function getLabelChanges()
    {
        return $this->revision->changes($this->user_id, $this->period);
    }

    /*
     * Partage changes
    * */
    public function getUsersHaveUpdate()
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

    /*
     * Convert change to labels
     * */
    public function getChangesConverted()
    {
        return $this->convertToLabels($this->getChanges(),$this->part);
    }

    /*
     * If there is differences get them but only for last and first
     * */
    public function getChanges(){

        $metas = $this->getLastMetas();

        if( $this->updates->count() > 1)
        {
            return $this->calculDiff(unserialize($this->updates->last()->labels), unserialize($this->updates->first()->labels));
        }
        elseif( $this->updates->count() == 1)
        {
            $last = $this->changes->getUserLastUpdates($this->user_id,$this->riiinglink->id);

            if( $this->riiinglink->id== 1009)
            {

                echo '<pre>';
                echo $this->riiinglink->id.'<br/>';
                print_r($last->first()->toArray());
                print_r($this->updates->first()->toArray());

                $diff =  $this->calculDiff([], unserialize($metas));

                echo '<pre>';
                print_r($diff);
                echo '</pre>';

            }

            if($metas && !$last->isEmpty())
            {
                if($this->updates->first()->name == 'created_meta')
                {
                    $this->calculDiff([], unserialize($metas));
                }
                else
                {
                    return $this->calculDiff(unserialize($last->first()->labels),unserialize($this->updates->first()->labels));
                }
            }

            return [];

        }
        elseif($this->updates->count() == 0)
        {
            $last = $this->changes->getUserLastUpdates($this->user_id,$this->riiinglink->id);

            if($metas && !$last->isEmpty())
            {
               return $this->calculDiff(unserialize($last->first()->labels), unserialize($metas));
            }
        }

        return [];
    }

    public function getLastMetas()
    {
        $meta = $this->meta->findByRiiinglink($this->riiinglink->id);

        if(!$meta->isEmpty())
        {
            return $meta->first()->labels;
        }
        else
        {
            return false;
        }
    }

    /**
     * Which = added or deleted
     * @return array difference
    * */
    public function convertToLabels($difference)
    {
        $this->label->invited = $this->invited;

        if( !empty($difference) && isset($difference[$this->part]) && !empty($difference[$this->part]) )
        {
            return $data[$this->part] = $this->label->getLabels($difference[$this->part],true);
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