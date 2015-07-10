<?php namespace App\Riiingme\Groupe\Repo;

use App\Riiingme\Groupe\Entities\Groupe as M;

class GroupeEloquent implements GroupeInterface {

    public function __construct(M $groupe){

        $this->groupe = $groupe;
    }

    public function getAll($type = null){

        $groupe = $this->groupe->with(['groupe_type' => function($query){

            $query->orderBy('rang', 'asc');

        }]);

        if($type){

            $groupe->whereHas('user_types', function($q) use($type)
            {
                $q->where('user_type_id', '=', $type);

            });
        }

        return $groupe->get();
    }

    public function find($id){

        return $this->groupe->findOrFail($id);
    }

}
