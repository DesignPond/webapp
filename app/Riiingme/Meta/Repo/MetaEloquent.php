<?php namespace App\Riiingme\Meta\Repo;

use App\Riiingme\Meta\Repo\MetaInterface;
use App\Riiingme\Meta\Entities\Meta as M;

class MetaEloquent implements MetaInterface {

    public function __construct(M $meta){

        $this->meta = $meta;
    }

    public function getAll(){

        return $this->meta->with(array('labels'))->get();
    }

    public function find($id){

        return $this->meta->find($id);
    }

    public function findAll($ids){

        return $this->meta->whereIn('riiinglink_id',$ids)->get();
    }

    public function deleteAll($ids){

        return $this->meta->whereIn('riiinglink_id',$ids)->delete();
    }

    public function findByRiiinglink($id){

        return $this->meta->where('riiinglink_id','=',$id)->get();
    }

    public function create(array $data){

        $meta = $this->meta->create([
            'riiinglink_id' => $data['riiinglink_id'],
            'labels'        => $data['labels']
        ]);

        if(!$meta){
            return false;
        }

        return $meta;
    }

    public function delete($id){

        $meta = $this->meta->find($id);

        if( ! $meta )
        {
            return false;
        }

        return $meta->delete($id);
    }
}
