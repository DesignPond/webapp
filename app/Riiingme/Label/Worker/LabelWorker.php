<?php namespace App\Riiingme\Label\Worker;

use App\Riiingme\Label\Repo\LabelInterface;
use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Type\Repo\TypeInterface;

class LabelWorker{

    protected $label;
    protected $groupe;
    protected $type;
    protected $helper;

    public function __construct(LabelInterface $label, GroupeInterface $groupe, TypeInterface $type)
    {
        $this->label  = $label;
        $this->groupe = $groupe;
        $this->type   = $type;
        $this->helper = new \App\Riiingme\Helpers\Helper;
    }

    public function labelByGroupeType($id){

        $labels = $this->label->findByUser($id);

        if(!$labels->isEmpty())
        {
            foreach($labels as $groupe_type)
            {
                $data[$groupe_type->groupe_id][$groupe_type->type_id]['type_id'] = $groupe_type->type_id;
                $data[$groupe_type->groupe_id][$groupe_type->type_id]['label'] = $groupe_type->label;
                $data[$groupe_type->groupe_id][$groupe_type->type_id]['id'] = $groupe_type->id;
            }
        }

        return (isset($data) ? $data : []);

    }

    public function convertLabels($inputs, $user_id, $groupe, $date = null){

        $data = [];

        if(!empty($inputs))
        {
            foreach($inputs as $type_id => $text)
            {
                if(!empty($text) && $text != ''){
                    $data[] = ['label' => $text, 'user_id' => $user_id, 'groupe_id' => $groupe, 'type_id' => $type_id];
                }
            }
        }

        return $data;

    }

    public function createLabels($inputs, $user_id, $groupe, $date = null){

        $labels = $this->convertLabels($inputs, $user_id, $groupe, $date);

        foreach($labels as $label)
        {
            $this->label->create($label);
        }

        return true;
    }

    public function updateLabels($label){

        if(!empty($label))
        {
            foreach($label as $id => $label)
            {
                $this->label->update(array('id' => $id, 'label' => $label));
            }
        }
    }

    public function labelForUser($partage,$user){

        $metas = [];

        if(!empty($partage))
        {
            foreach($partage as $groupe => $types)
            {
                foreach($types as $type)
                {
                    $label = $this->label->findByUserGroupeType($user,$groupe,$type);

                    if(!$label->isEmpty())
                    {
                        $metas[] = $label->first()->id;
                    }
                }
            }
        }

        return (!empty($metas) ? $metas : []);
    }

}