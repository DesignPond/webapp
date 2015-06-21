<?php namespace App\Riiingme\Activite\Repo;

use App\Riiingme\Activite\Repo\ChangeInterface;
use App\Riiingme\Activite\Entities\Change as M;

class ChangeEloquent implements ChangeInterface {

    public function __construct(M $change){

        $this->change = $change;
    }

    public function getAll($period){

        return $this->change->with(['riiinglink'])->period($period)->groupBy('user_id')->orderBy('id', 'desc')->get();
    }

    public function getUpdated($user_id,$period){

        return $this->change->with(['user','riiinglink'])->whereHas('riiinglink', function ($query) use ($user_id)
        {
            $query->where('riiinglinks.invited_id','=',$user_id);

        })->where('user_id','!=',$user_id)->period($period)->orderBy('id', 'desc')->get();
    }

    public function getUserUpdates($user_id,$riiinglink_id,$period){

        return $this->change->where('user_id','=',$user_id)
            ->where('riiinglink_id','=',$riiinglink_id)
            ->where(function($query)
            {
                $query->where('name','=','updated_meta')->orWhere('name','=','created_meta');

            })->period($period)->orderBy('id', 'desc')->get();
    }

    public function getUserLastUpdates($user_id,$riiinglink_id){

        return $this->change->where('user_id','=',$user_id)
            ->where('riiinglink_id','=',$riiinglink_id)->orderBy('id', 'desc')->skip(1)->take(2)->get();
    }

    public function getLastChanges(){

        return $this->change->with(['user','riiinglink'])
            ->where('name','=','updated_meta')
            ->whereBetween('changed_at', array(\Carbon\Carbon::now()->toDateString(), \Carbon\Carbon::now()->addWeek()->toDateString()))
            ->orderBy('id', 'desc')
            ->get();
    }

    public function find($id){

        return $this->change->find($id);
    }

    public function create(array $data){

        $change = $this->change->create([
            'meta_id'       => $data['meta_id'],
            'user_id'       => $data['user_id'],
            'riiinglink_id' => $data['riiinglink_id'],
            'labels'        => $data['labels'],
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
