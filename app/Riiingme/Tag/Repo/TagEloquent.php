<?php namespace App\Riiingme\Tag\Repo;

use App\Riiingme\Tag\Repo\TagInterface;
use App\Riiingme\Tag\Entities\Tag as M;

class TagEloquent implements TagInterface{
	
	protected $tag;
	
	public function __construct(M $tag){
	
		$this->tag = $tag;
	}
	
	public function getAll($user_id){
		
		return $this->tag->whereHas('user_tags', function($q) use ($user_id)
        {
            $q->where('user_id','=',$user_id);

        })->get();
	}
	
	public function find($id){

		return $this->tag->where('id','=',$id)->with(array('riiinglink_tags'))->get()->first();
	}
	
	public function search($term, $like = false){
	
		if($like)
		{
			return $this->tag->where('title','LIKE', '%'.$term.'%')->get();
		}
		else
		{
			return $this->tag->where('title','=', $term)->get()->first();
		}	
		
	}
	public function create(array $data){

		// Create the article
		$tag = $this->tag->create( array('title' => $data['title'], 'user_id' =>  $data['user_id']));
		
		if( ! $tag )
		{
			return false;
		}
		
		return $tag;
	}
	
}

