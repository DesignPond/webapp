<?php namespace App\Riiingme\Tag\Repo;

use App\Riiingme\Tag\Repo\TagInterface;
use App\Riiingme\Tag\Entities\Tag as M;

class TagEloquent implements TagInterface{
	
	protected $tag;
	
	public function __construct(M $tag){
	
		$this->tag = $tag;
	}
	
	public function getAll($user_id){
		
		return $this->tag->where('user_id','=',$user_id)->get();
	}
	
	public function find($id){

		return $this->tag->where('id','=',$id)->with(array('riiinglink_tags'))->get()->first();
	}
	
	public function getAllTagsForProjets($tags){
		
		$tags = $this->tag->with(array('projet_tags' => function($query) use ($tags){
	        
		        $query->where('projet_tag.tag_id', '=' ,$tags);
		        
	    }))->get();
	    
	    $projets = array();
	    
	    if(!$tags->isEmpty()){
		    
		    foreach($tags as $tag){
			    
			    $list = ( !$tag->projet_tags->isEmpty() ? $tag->projet_tags : null );
			    
			    if($list)
			    {
				    $projets = array_merge($projets, $list->lists('id'));
			    }			    
		    }		    
	    }
	    
	    return $projets;
		
	}
	
	public function dropChildren(){
	
		$tags = $this->tag->all();
	
		$drop = array();
		
		if(!$tags->isEmpty()){	
				
			$parents = $tags->map(function($tag)
		    {
		        return $tag->parents;
		    });
			
			foreach($tags as $tag){
				
			}			
		}		
	}
	
	public function droplist(){

        $tags = $this->tag->lists('title','id');

        if(!empty($tags))
        {
            return array('' => 'Choix') + $tags;
        }

        return $tags;

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
		$tag = $this->tag->create( array('title' => $data['title'] ));
		
		if( ! $tag )
		{
			return false;
		}
		
		return $tag;
	}
	
}

