<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Riiingme\Tag\Repo\TagInterface;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use Illuminate\Http\Request;

class TagController extends Controller {

	protected $tag;
	protected $riiinglink;

    public function __construct( TagInterface $tag,  RiiinglinkInterface $riiinglink){
		
		$this->tag        = $tag;
		$this->riiinglink = $riiinglink;

	}

	/**
	 *
	 * @return Response
	 */
	public function allTags()
	{
		$tags = $this->tag->getAll(\Auth::user()->id);
		
		return \Response::json( $tags, 200 );
	}
	
	public function tags(Request $request)
	{
		
		$term = $request->input('term');
		$tags = $this->tag->search($term,true);
		
		return \Response::json( $tags, 200 );
	}
	
	public function addTag(Request $request)
	{

		$id   = $request->input('id');
		$tag  = $request->input('tag');
		$find = $this->tag->search($tag);
				
		// If tag not found	
		if(!$find)
		{
			$find = $this->tag->create(array('title' => $tag));
		}
		
		$riiinglink = $this->riiinglink->find($id)->first();

        $riiinglink->tags()->attach($find->id);
		
		return \Response::json( $find , 200 );
	}
		
	public function removeTag(Request $request)
	{
		$id   =  $request->input('id');
		$tag  =  $request->input('tag');
		
		$find       = $this->tag->search($tag);
        $riiinglink = $this->riiinglink->find($id)->first();

        $riiinglink->tags()->detach($find->id);
		
		return \Response::json( $riiinglink, 200 );
	}

}