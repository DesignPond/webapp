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

        return $this->riiinglink->where('id','=',$id)->with(array('usermetas','tags'))->get();
    }

    public function findTags($tag_id,$riiinglinks){

        return $this->riiinglink->whereHas('tags', function($q) use ($tag_id,$riiinglinks)
            {
                $q->where('tag_id','=',$tag_id);
                $q->whereIn('riiinglink_id', $riiinglinks);

            })->get();
    }

    /**
     * Riiinglinks for scope and user_id
     */
    public function findBy($id,$scope,$params = null){

        $riiinglink = $this->riiinglink->$scope($id)->orderBy('created_at','desc');

        return $riiinglink->get();
    }

    /**
     * Riiinglinks for host and invited infos
     */
    public function findByHost($user_id,$tags = null){

        $riiinglink = $this->riiinglink->where('host_id','=',$user_id)->with(array('invite'));

        if($tags)
        {
            $riiinglink->whereHas('tags',function ($q) use ($tags)
            {
                $q->whereIn('tag_id',$tags);
            });
        }

        return $riiinglink->get();
    }

    public function latest($user_id){

        return $this->riiinglink->where('host_id','=',$user_id)->with(array('invite'))->orderBy('created_at','desc')->take(6)->get();
    }

    public function findByHostWithParams($user_id,$params){

        $results = $this->riiinglink->where('host_id','=',$user_id);

        if(!empty($params))
        {
            $results->with(array('invite'));
        }

        if(isset($params['tag']) && !empty($params['tag']))
        {
            $results->with(array('tags','invite'))->whereHas('tags', function($q) use($params)
            {
                $q->where('tag_id', '=', $params['tag']);
            });
        }

        if(isset($params['search']) && !empty($params['search']))
        {

            $results->join('users', 'users.id', '=', 'riiinglinks.invited_id')
                ->where(function($query) use($params)
                {
                    $query->where('first_name', 'like', '%'.$params['search'].'%');
                    $query->orWhere('last_name', 'like', '%'.$params['search'].'%');
                    $query->orWhere('email', 'like', '%'.$params['search'].'%');
                })
                ->select('riiinglinks.*','users.first_name','users.last_name','users.email')
                ->with(['tags','invite']);
        }

        if(isset($params['orderBy']) && !empty($params['orderBy']))
        {
            if($params['orderBy'] == 'created_at')
            {
                $results->orderBy('created_at', 'asc');
            }

            if($params['orderBy'] == 'last_name')
            {
                $results->join('users', 'users.id', '=', 'riiinglinks.invited_id')
                    ->orderBy('users.last_name', 'asc')
                    ->select('riiinglinks.*','users.last_name')       // just to avoid fetching anything from joined table
                    ->with(['tags','invite']);
            }
        }
        else
        {
            $results->orderBy('created_at', 'desc');
        }


        return $results->paginate(9);
    }

    /**
     * Riiinglink current user and invited switching places here
     */
    public function findByHostAndInvited($host_id,$invited_id){

        $riiinglink = $this->riiinglink->where('host_id','=',$host_id)->where('invited_id','=',$invited_id)->with(array('tags'))->get();

        if(!$riiinglink)
        {
            return false;
        }

        return $riiinglink->first();
    }

    public function create(array $data){

        $hosted = $this->riiinglink->create([
            'host_id'    => $data['host_id'],
            'invited_id' => $data['invited_id']
        ]);

        if(!$hosted){
            return false;
        }

        $invited = $this->riiinglink->create([
            'host_id'    => $data['invited_id'],
            'invited_id' => $data['host_id']
        ]);

        if(!$invited){
            return false;
        }

        return [$hosted,$invited];
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
