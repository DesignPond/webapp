<?php namespace App\Riiingme\Export\Worker;

use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Label\Worker\LabelWorker;
use App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;

class ExportWorker{

    protected $riiinglink;
    protected $groupe;
    protected $label;
    protected $worker;
    protected $hiddenTypes;
    protected $transformer;

    public $types;
    public $user;
    public $tags;
    public $labels = null;
    public $groupes;
    public $user_riiinglinks;

    public function __construct(GroupeWorker $groupe, RiiinglinkInterface $riiinglink, LabelWorker $label, RiiinglinkTransformer $transformer, RiiinglinkWorker $worker )
    {
        $this->riiinglink  = $riiinglink;
        $this->groupe      = $groupe;
        $this->label       = $label;
        $this->worker      = $worker;
        $this->transformer = $transformer;
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

    public function setLabels($labels){

        $this->labels = $labels;

        return $this;
    }

    public function setGroupes($groupes){

        if(is_array($groupes) && !empty($groupes))
        {
            $groupes[] = ( in_array(2,$groupes) ? 4 : null);
            $groupes[] = ( in_array(3,$groupes) ? 5 : null);
            $groupes   = array_filter($groupes);
        }

        $this->groupes = $groupes;

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
                // Find riinglink inverse
                $invite = $this->loadLabelsAndGroupes($riiinglink);
                $data   = $this->userLabelsInGroupes($invite);

                $user = $this->label->periodIsInEffect($invite->invite->users_groups,$data);

                if(!empty($user))
                {
                    $user_data[$riiinglink->invite->id] = $user;
                }

            }
        }

        return $this->dispatchTypes($user_data, $this->hiddenTypes);

    }

    public function userLabelsInGroupes($invite)
    {
        $data = [];

        if(!empty($invite->labels))
        {
            $labels = $invite->labels;
            unset($labels[1]);

            foreach ($labels as $groupe_id => $groupe)
            {
                if( empty($this->groupes) || (!empty($this->groupes) && in_array($groupe_id,$this->groupes)) )
                {
                    $data[$groupe_id][0] = $invite->invite->name;

                    foreach ($groupe as $type_id => $label)
                    {
                        if(empty($this->labels) || (!empty($this->labels) && in_array($type_id,$this->labels)) )
                        {
                           $data[$groupe_id][$type_id] = $label;
                        }
                    }
                }
            }
        }
        
        return $data;
    }

    public function loadLabelsAndGroupes($riiinglink)
    {

        $this->transformer->invited =  $this->transformer->getUser($riiinglink->invited_id);
        $labels = $this->transformer->getInvitedLabels($riiinglink);

        $riiinglink->setAttribute('labels',$labels);
        $riiinglink->invite->load('users_groups');

        return $riiinglink;
    }

    public function dispatchTypes($user_data)
    {
        $lines = [];

        if(!empty($user_data))
        {
            foreach($user_data as $data)
            {
                foreach($data as $data_groupe => $line)
                {
                    $lines[] = $this->label->typeForGroupes($line,$this->labels);
                }
            }
        }

        return $lines;
    }

    public function unsetHiddenTypes(){

        // Remove hidden from list
        if(!empty($this->hiddenTypes))
        {
            foreach($this->hiddenTypes as $hidden)
            {
                if(isset($this->types[$hidden]))
                {
                    unset($this->types[$hidden]);
                }
            }
        }

        return $this;
    }

    public function getUserRiiinglinks()
    {
        $this->user_riiinglinks = $this->riiinglink->findByHost($this->user,$this->tags);

        return $this;
    }

    public function prepareLabelsTitle(){

        $types = $this->groupe->getTypes();

        if(!empty($this->hiddenTypes))
        {
            foreach($this->hiddenTypes as $hidden)
            {
                if(isset($types[$hidden])){ unset($types[$hidden]); }
            }
        }

        if(!empty($this->labels))
        {
            foreach($this->labels as $label)
            {
                $new[$label] = $types[$label];
            }

            return [0 => 'Pénom et nom'] + $new;
        }

        return [0 => 'Pénom et nom'] + $types;

    }

}