<?php namespace App\Riiingme\Activite\Repo;

use App\Riiingme\Activite\Repo\ChangeInterface;
use App\Riiingme\Activite\Entities\Change as M;

class ChangeEloquent implements ChangeInterface {

    public function __construct(M $change){

        $this->change = $change;
    }

    public function getAll($user_id){

        return $this->change->with(['user','riiinglink'])->whereHas('riiinglink', function ($query) use ($user_id)
        {
            $query->where('riiinglinks.invited_id','=',$user_id);

        })->get();
    }

    public function find($id){

        return $this->change->find($id);
    }

    public function create(array $data){

        $change = $this->change->create([
            'meta_id'       => $data['meta_id'],
            'user_id'       => $data['user_id'],
            'riiinglink_id' => $data['riiinglink_id'],
            'changed_at'    => date('Y-m-d G:i:s'),
            'name'          => $data['name']
        ]);

        if(!$change){
            return false;
        }

        return $change;
    }

    public function update(array $data){

        $change = $this->change->findOrFail($data['id']);

        if( ! $change )
        {
            return false;
        }

        $change->fill($data);
        $change->save();

        return $change;
    }

    public function delete($id){

        $change = $this->change->find($id);

        if( ! $change )
        {
            return false;
        }

        return $change->delete($id);
    }
}
