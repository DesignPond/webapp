<?php namespace App\Riiingme\Label\Worker;

use App\Riiingme\Label\Repo\LabelInterface;
use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Type\Repo\TypeInterface;
use App\Riiingme\User\Entities\User_group;
use App\Riiingme\User\Repo\UserInterface;

class LabelWorker{

    protected $label;
    protected $groupe;
    protected $type;
    protected $helper;
    protected $user;

    public $all_types;

    public function __construct(UserInterface $user, LabelInterface $label, GroupeInterface $groupe, TypeInterface $type)
    {
        $this->label  = $label;
        $this->groupe = $groupe;
        $this->type   = $type;
        $this->user   = $user;
        $this->helper = new \App\Riiingme\Helpers\Helper;

        $this->all_types = $this->type->getAll()->lists('id');
        unset($this->all_types[12]);
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

    public function typeForGroupes($data_groupe,$labels = null)
    {
        $data  = [];

        $types = ($labels && !empty($labels) ? $labels : $this->all_types);
        $types = array_merge([0 => 0],$types);

        foreach($types as $type)
        {
            $data[$type] = ( isset($data_groupe[$type]) && !empty($data_groupe[$type]) ? $data_groupe[$type] : '');
        }

        return $data;
    }

    public function convertLabels($inputs, $user_id, $groupe){

        $data = [];

        if(!empty($inputs))
        {
            foreach($inputs as $type_id => $text)
            {
                if(!empty($text) && $text != '')
                {
                    $data[] = ['label' => $text, 'user_id' => $user_id, 'groupe_id' => $groupe, 'type_id' => $type_id];
                }
            }
        }

        return $data;

    }

    public function createLabels($inputs, $user_id, $groupe, $date = null){

        $labels = $this->convertLabels($inputs, $user_id, $groupe);
        
        if($date)
        {
            $user = $this->user->find($user_id);

            $this->updatePeriodRange($user, $groupe, $date);
        }

        foreach($labels as $label)
        {
            $this->label->create($label);
        }

        return true;
    }

    public function updatePeriodRange($user, $groupe, $date = null){

        $ug = $user->user_groups()->where('groupe_id','=',$groupe)->get();

        if(!$ug->isEmpty())
        {
            $user->user_groups()->detach($ug->first()->id);
        }

        if($date)
        {
            $daterange = $this->helper->convertDateRange($date);

            $user->user_groups()->attach($groupe, $daterange);

            return true;
        }
    }

    public function updateLabels($label,$user_id,$date){

        if($date)
        {
            $user = $this->user->find($user_id);
            $date = array_filter($date);

            foreach($date as $groupe => $range)
            {
                $daterange = $this->helper->convertDateRange($range);

                $user->user_groups()->sync([$groupe => $daterange]);
            }
        }

        if(!empty($label))
        {
            foreach($label as $id => $item)
            {
                if($item != '')
                {
                    $this->label->update(array('id' => $id, 'label' => $item));
                }
                else
                {
                    $this->label->delete($id);
                }
            }
        }
    }

    public function convertPartgeUserType($partage,$user){

        $isUser = $this->user->find($user);

        if($isUser->user_type == 2 && ( isset($partage[2]) || isset($partage[3]) ))
        {
            return $this->helper->convertForUserType($partage);
        }

        return $partage;

    }

    public function labelForUser($partage,$user){

        $metas = [];

        if(!empty($partage))
        {
            // Assure we get correct labels to partage
            $partage = $this->convertPartgeUserType($partage,$user);

            foreach($partage as $groupe => $types)
            {
                foreach($types as $type)
                {
                    $label = $this->label->findByUserGroupeType($user,$groupe,$type);

                    if(!$label->isEmpty())
                    {
                        $metas[$groupe][$type] = $label->first()->id;
                    }
                }
            }
        }

        return (!empty($metas) ? $metas : []);
    }

    public function updatePhoto($user_id,$label,$id){

        $exist = $this->label->findPhotoByUser($user_id);

        if($exist)
        {
            return $this->label->update(array('id' => $id, 'label' => $label));
        }
        else
        {
            return $this->label->create([
                'label'     => $label,
                'user_id'   => $user_id,
                'type_id'   => 12,
                'groupe_id' => 1
            ]);
        }
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