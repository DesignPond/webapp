<?php namespace App\Riiingme\Riiinglink\Repo;

use App\Riiingme\Riiinglink\Entities\Riiinglink as M;

class RiiinglinkEloquent implements RiiinglinkInterface {

    public function __construct(M $riiinglink){

        $this->riiinglink = $riiinglink;
    }
    public function getAll(){

        return $this->riiinglink->with(array('user'))->get();

    }

    public function find($id){

        //return $this->riiinglink->where('id','=',$id)->with(array('labels'))->get();

        return $this->riiinglink->where('id','=',$id)->with(array('usermetas'))->get();
    }

    /**
     * Riiinglinks for scope and user_id
     */
    public function findBy($id,$scope){

        return $this->riiinglink->$scope($id)->orderBy('created_at','desc')->get();
    }

    /**
     * Riiinglinks for host and invited infos
     */
    public function findByHost($user_id){

        return $this->riiinglink->where('host_id','=',$user_id)->with(array('invite'))->get();
    }

    public function findByHostWithParams($user_id,$params){

        $results = $this->riiinglink->where('host_id','=',$user_id);

        if(isset($params['search']))
        {
            $search = $params['search'];

            $results->with(array('invite' => function($query) use ($search)
            {
                $query->where('first_name', 'like', '%'.$search.'%');
                $query->orWhere('last_name', 'like', '%'.$search.'%');
                $query->orWhere('email', 'like', '%'.$search.'%');

            }));
        }
/*        else if(isset($params['order']) && !empty($params['order'])){

            $order = $params['order'];

            $results->whereHas('invite', function($q) use ($order)
            {
                $q->orderBy($order, 'asc');
            });

        }*/
/*        else if(isset($params['label'])){

            $results->whereHas('invite', function($q)
            {
                $q->where('content', 'like', 'foo%');

            });
        }*/
        else
        {
            $results->with(array('invite'));
        }

        return $results->paginate(10);
    }

    /**
     * Riiinglink current user and invited switching places here
     */
    public function findByHostAndInvited($invited_id,$host_id){

        return $this->riiinglink->where('host_id','=',$invited_id)->where('invited_id','=',$host_id)->with(array('labels'))->get()->first();
    }

    public function create(array $data){

        $riiinglink = $this->riiinglink->create([
            'host_id'    => $data['host_id'],
            'invited_id' => $data['invited_id']
        ]);

        if(!$riiinglink){
            return false;
        }

        return $riiinglink;
    }

    public function delete($id){

        $riiinglink = $this->riiinglink->find($id);

        if( ! $riiinglink )
        {
            return false;
        }

        return $riiinglink->delete($id);
    }

}
