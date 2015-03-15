<?php namespace App\Riiingme\Type\Repo;

use App\Riiingme\Type\Repo\TypeInterface;
use App\Riiingme\Type\Entities\Type as M;

class TypeEloquent implements TypeInterface {

    public function __construct(M $type){

        $this->type = $type;
    }
    public function getAll(){

        return $this->type->all();
    }
    public function find($id){

        return $this->type->findOrFail($id);
    }

}
