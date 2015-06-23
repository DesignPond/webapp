<?php namespace App\Riiingme\Riiinglink\Worker;

use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Meta\Repo\MetaInterface;

class ConvertWorker{

    protected $label;
    protected $meta;
    protected $riiinglink;
    protected $user;

    public $labels = [];
    public $metas = [];
    public $link;
    public $userGroup;
    public $userType;

    public function __construct( RiiinglinkInterface $riiinglink, GroupeInterface $groupe, MetaInterface $meta, UserInterface $user)
    {
        $this->riiinglink  = $riiinglink;
        $this->groupe      = $groupe;
        $this->meta        = $meta;
        $this->user        = $user;
        $this->helper      = new \App\Riiingme\Helpers\Helper;
    }

    public function loadUserLabels($riiinglink, $host = null)
    {
        if($host)
        {
            $this->link = $riiinglink;
        }
        else
        {
            $this->link = $this->riiinglink->findByHostAndInvited($riiinglink->invited_id,$riiinglink->host_id);
        }

        $labels = $this->user->find($this->link->host_id);
        $metas  = $this->meta->findByRiiinglink($this->link->id);

        $this->metas     = (!$metas->isEmpty() ? unserialize($metas->first()->labels) : '');
        $this->labels    = $labels->labels;
        $this->userGroup = $labels->users_groups;
        $this->userType  = $labels->user_type;

        return $this;
    }

    public function metasInEffect()
    {
        if(!empty($this->metas))
        {
            $metas = array_map("array_keys", $this->metas);

            if($this->userType == 1)
            {
                // Duplicate temp groups
                $metas[4] = (isset($metas[2]) && !empty($metas[2]) ? $metas[2] : []);
                $metas[5] = (isset($metas[3]) && !empty($metas[3]) ? $metas[3] : []);
            }

            $this->metas = $metas;
        }

        return $this;
    }

    public function labelsToShow()
    {
        $labels = [];

        if(!empty($this->labels))
        {
            foreach($this->labels as $groupe => $types)
            {
                if(isset($this->metas[$groupe]))
                {
                    foreach($types as $type => $label)
                    {
                        if(in_array($type,$this->metas[$groupe]))
                        {
                            $labels[$groupe][$type] = $label;
                        }
                    }
                }
            }
        }

        $this->labels = $labels;

        return $this;
    }

    public function addName(){

        $data = [];

        $this->link->load('host');
        $name = $this->link->host->name;
        
        if(!empty($this->labels))
        {
            foreach($this->labels as $groupe => $labels)
            {
                $data[$groupe] = [0 => $name] + $labels;
            }
        }

        $this->labels = $data;

        return $this;
    }

    public function prepareLabels(){

        if(!empty($this->labels))
        {
            foreach($this->labels as $label)
            {
                $labels[$label->groupe_id][$label->type_id] = $label->label_text;
            }
        }

        if(!empty($labels))
        {
            $this->labels = $labels;
        }

        return $this;
    }

    public function convertChanges($changes){

        foreach($changes as $groupe => $types)
        {

            if($groupe == 2 && isset($this->labels[4]))
            {
                $used = $this->labels[2];
                $temp = $this->labels[4];

                foreach($types as $type => $label)
                {
                    $changes[4][$type] = (isset($temp[$type]) && !empty($temp[$type]) ? $temp[$type] : $used[$type]);
                }
            }

            if($groupe == 3 && isset($this->labels[5]))
            {
                $used = $this->labels[3];
                $temp = $this->labels[5];

                foreach($types as $type => $label)
                {
                    $changes[5][$type] = (isset($temp[$type]) && !empty($temp[$type]) ? $temp[$type] : $used[$type]);
                }
            }
        }

        $this->labels = $changes;

        return $this;

    }

    public function convertPeriodRange(){

        if(!empty($this->labels))
        {
            $this->labels = $this->periodIsInEffect($this->userGroup,$this->labels);
        }

        return $this;
    }

    public function periodIsInEffect($users_groups, $data)
    {
        $isGroupe  = [4 => 2, 5 => 3];

        foreach($isGroupe as $temp => $normal)
        {
            $tempExist = $users_groups->filter(function ($item) use ($temp) {
                return $item->groupe_id == $temp;
            })->first();

            if($tempExist && $tempExist->period_range)
            {
                unset($data[$normal]);
            }
            else
            {
                unset($data[$temp]);
            }
        }

        return (!empty($data) ? $data : []);
    }

}