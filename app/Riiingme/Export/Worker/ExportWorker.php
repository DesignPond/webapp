<?php namespace App\Riiingme\Export\Worker;

use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Label\Worker\LabelWorker;

class ExportWorker{

    protected $riiinglink;
    protected $groupe;
    protected $label;
    protected $hiddenTypes;
    public $types;
    public $user;
    public $tags;
    public $user_riiinglinks;

    public function __construct(GroupeWorker $groupe, RiiinglinkInterface $riiinglink, LabelWorker $label)
    {
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;
        $this->label      = $label;

        $this->hiddenTypes = [12];
    }

    public function setTypes(){

        $this->types = $this->groupe->getTypes();
        
        return $this;

    }

    public function setTags($tags){

        $this->tags = $tags;

        return $this;

    }

    public function setUser($user_id){

        $this->user = $user_id;

        return $this;
    }

    public function userExport()
    {

        $user_data = [];
        $lines[]   = array_merge([0 => 'Prénom et nom'],$this->types);

        if(!$this->user_riiinglinks->isEmpty())
        {
            foreach($this->user_riiinglinks as $riiinglink)
            {
                $data   = [];

                $invite = $this->loadLabelsAndGroupes($riiinglink);
                $data   = $this->userLabelsInGroupes($invite);

                $user_data[$riiinglink->invite->id] = $this->label->periodIsInEffect($invite->users_groups,$data);
            }
        }

        return $this->dispatchTypes($user_data, $this->hiddenTypes);

    }

    public function userLabelsInGroupes($invite)
    {
        $data = [];

        if(!$invite->labels->isEmpty())
        {
            foreach ($invite->labels as $groupe)
            {
                if ($groupe->groupe_id > 1)
                {
                    $data[$groupe->groupe_id][0] = $invite->name;
                    $data[$groupe->groupe_id][$groupe->type_id] = $groupe->label;
                }
            }
        }

        return $data;
    }

    public function loadLabelsAndGroupes($riiinglink)
    {
        return $riiinglink->invite->load('labels','users_groups');
    }

    public function dispatchTypes($user_data, $unset = [])
    {
        $lines = [];

        if(!empty($user_data))
        {
            foreach($user_data as $data)
            {
                foreach($data as $data_groupe => $line)
                {
                    $lines[] = $this->label->typeForGroupes($line,$unset);
                }
            }
        }

        return $lines;
    }

    public function unsetHiddenTypes(){
        // Remove hidden from list
        if(!empty($this->hiddenTypes))
        {
            $this->types = array_diff($this->types,$this->hiddenTypes);
        }

        return $this;
    }

    public function getUserRiiinglinks()
    {
        $this->user_riiinglinks = $this->riiinglink->findByHost($this->user,$this->tags);

        return $this;
    }


}