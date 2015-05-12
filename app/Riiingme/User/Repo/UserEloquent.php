<?php namespace App\Riiingme\User\Repo;

use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\User\Entities\User as M;

class UserEloquent implements UserInterface {

    public function __construct(M $user){

        $this->user = $user;
    }

    public function getAll($period = null){

        if($period)
        {
            return $this->user->with(array('labels'))->where('notification_interval','=',$period)->get();
        }

        return $this->user->all();
    }

    public function getEmails($ids){

        return $this->user->whereIn('id', [$ids] )->get()->lists('email');
    }

    public function find($id){

        return $this->user->with(array('labels','user_groups','user_tags'))->findOrFail($id);
    }

    public function search($term){

        $id = \Auth::user()->id;

        return $this->user
            ->whereNotIn('id', [$id] )
            ->where(function($query) use ($term)
            {
                $query->where('email','like', '%'.$term.'%')
                    ->orWhere('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%')
                    ->orWhere('company', 'like', '%'.$term.'%');

            })->get();
    }

    public function findByEmail($email){

        $user = $this->user->where('email','=', $email)->get();

        return (!$user->isEmpty() ? $user->first() : null);
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

        \Auth::login($user);

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

        return $user->delete($id);

    }

}
