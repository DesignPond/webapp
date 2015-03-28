<?php namespace App\Riiingme\Activite\Repo;

use App\Riiingme\Activite\Repo\ActiviteInterface;
use App\Riiingme\Activite\Entities\Activite as M;

class ActiviteEloquent implements ActiviteInterface {

    public function __construct(M $activite){

        $this->activite = $activite;
    }

    public function getAll(){

        return $this->activite->all();
    }

    public function find($id){

        return $this->activite->find($id);
    }

    public function create(array $data){

        $activite = $this->activite->create([
            'type'        => $data['type'],
            'activite_id' => $data['activite_id'],
            'user_id'     => $data['user_id'],
            'invited_id'  => $data['invited_id']
        ]);

        if(!$activite){
            return false;
        }

        return $activite;
    }

    public function update(array $data){

        $activite = $this->activite->findOrFail($data['id']);

        if( ! $activite )
        {
            return false;
        }

        $activite->fill($data);
        $activite->save();

        return $activite;
    }

    public function delete($id){

        $activite = $this->activite->find($id);

        if( ! $activite )
        {
            return false;
        }

        return $activite->delete($id);
    }
}
