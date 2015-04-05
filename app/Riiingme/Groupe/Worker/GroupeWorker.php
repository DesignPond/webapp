<?php namespace App\Riiingme\Groupe\Worker;

use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Type\Repo\TypeInterface;

class GroupeWorker{

    protected $groupe;
    protected $type;

    public function __construct(GroupeInterface $groupe, TypeInterface $type)
    {

        $this->groupe  = $groupe;
        $this->type    = $type;

    }

    public function getDependencies($user_type){

        return [
            'groupes'      => $this->getGroupes(),
            'types'        => $this->getTypes(),
            'status'       => $this->getGroupesStatus(),
            'groupe_type'  => $this->getGroupesTypes($user_type),
            'groupes_user' => $this->getGroupesUser($user_type),
        ];

    }

    public function getAllGroupes($user_type = null){

        return $this->groupe->getAll($user_type);
    }

    public function getGroupes(){

        return $this->getAllGroupes()->lists('titre','id');
    }

    public function getGroupesStatus(){

        return $this->getAllGroupes()->lists('status','id');
    }

    public function getGroupesUser($user_type){

        return $this->getAllGroupes($user_type)->lists('titre','id');
    }

    public function getGroupesTypes($user_type){

        return $this->getAllGroupes($user_type)->toArray();
    }

    public function getTypes()
    {
        return $this->type->getAll()->lists('titre','id');
    }

}