<?php namespace App\Riiingme\Invite\Repo;

use App\Riiingme\Invite\Repo\InviteInterface;
use App\Riiingme\Invite\Entities\Invite as M;
use App\Riiingme\Event\InviteCreated;

class InviteEloquent implements InviteInterface {

    public function __construct(M $invite){

        $this->invite = $invite;
    }

    public function getAll($user_id){

        return $this->invite->where('user_id','=',$user_id)->get();
    }

    public function find($id){

        return $this->invite->with(array('user'))->where('id','=',$id)->get()->first();
    }

    public function setToken($id){

        $invite = $this->invite->find($id);
        $email  = $invite->email;
        $token  = md5($id.$email);

        $invite->token = $token;
        $invite->save();

        return $invite;
    }

    public function validate($token){

        $invite = $this->invite->where('token','=',$token)->get();
        return (!$invite->isEmpty() ? $invite->first() : null);

    }

    public function create(array $data){

        $invite = $this->invite->create([
            'email'           => $data['email'],
            'user_id'         => $data['user_id'],
            'invited_id'      => (isset($data['invited_id']) ? $data['invited_id'] : null),
            'partage_host'    => $data['partage_host'],
            'partage_invited' => $data['partage_invited'],
            'created_at'      => date('Y-m-d G:i:s'),
            'updated_at'      => date('Y-m-d G:i:s')
        ]);

        if(!$invite){
            return false;
        }

        return $invite;
    }

    public function update(array $data){

        $invite = $this->invite->findOrFail($data['id']);

        if( ! $invite )
        {
            return false;
        }

        $invite->invited_id = $data['invited_id'];

        $invite->save();

        return $invite;
    }

    public function delete($id){

        $invite = $this->invite->find($id);

        if( ! $invite )
        {
            return false;
        }

        return $invite->delete($id);
    }

}
