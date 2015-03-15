<?php namespace App\Riiingme\User\Repo;

use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\User\Entities\User as M;

class UserEloquent implements UserInterface {

    public function __construct(M $user){

        $this->user = $user;
    }

    public function getAll(){

        return $this->user->with(array('labels'=> function ($query)
        {
            $query->join('types','types.id','=','labels.type_id')->select('types.titre');

        }))->get();
    }

    public function find($id){

        return $this->user->with(array('labels'))->findOrFail($id);
    }

    public function search($term){

        return $this->user->where('email','LIKE', '%'.$term.'%')->get();

    }

    public function findByEmail($email){

        return $this->user->where('email','=', $email)->get();

    }

    public function activate($token){

        $user = $this->user->where('activation_token','=',$token)->get()->first();

        if( ! $user )
        {
            return false;
        }

        $user->activated_at = date('Y-m-d G:i:s');
        $user->updated_at   = date('Y-m-d G:i:s');

        $user->save();

        return $user;

    }

    public function create(array $data){

        $user = $this->user->create(array(
            'email'            => $data['email'],
            'first_name'       => $data['first_name'],
            'last_name'        => $data['last_name'],
            'company'          => $data['company'],
            'user_type'        => $data['user_type'],
            'activation_token' => $data['activation_token'],
            'password'         => $data['password']
        ));

        if( ! $user )
        {
            return false;
        }

        return $user;

    }

    public function update(array $data){

        $user = $this->user->findOrFail($data['id']);

        if( ! $user )
        {
            return false;
        }

        $user->fill($data);

        $user->save();

        return $user;
    }

    public function delete($id){

        $user = $this->user->find($id);

        return $user->delete();

    }

}
