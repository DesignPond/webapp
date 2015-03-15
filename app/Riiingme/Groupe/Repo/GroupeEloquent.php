<?php namespace App\Riiingme\Groupe\Repo;

use App\Riiingme\Groupe\Entities\Groupe as M;

class GroupeEloquent implements GroupeInterface {

    public function __construct(M $groupe){

        $this->groupe = $groupe;
    }

    public function getAll(){

        return $this->groupe->with(array('groupe_type'))->get();
    }

    public function find($id){

        return $this->groupe->findOrFail($id);
    }

}
