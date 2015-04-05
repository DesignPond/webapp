<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Meta\Worker\MetaWorker;
use App\Riiingme\Groupe\Worker\GroupeWorker;

class RiiinglinkController extends Controller {

    protected $riiinglink;
    protected $user;
    protected $meta;
    protected $groupe;

    public function __construct(UserInterface $user, MetaWorker $meta, GroupeWorker $groupe, RiiinglinkWorker $riiinglink)
    {
        $this->middleware('auth');

        $this->user       = $user;
        $this->meta       = $meta;
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;

        $this->auth = $this->user->find(\Auth::user()->id);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $data  = $this->riiinglink->getRiiinglinkWithParams($this->auth->id, $request->all() );

        return \Response::json( $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function total()
	{
        return $this->riiinglink->riiinglinkCollection($this->auth->id)->count();
	}

    /**
     * Display the specified resource.
     * GET /user/link/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // Get riiinglink from id
        $link = $this->riiinglink->riiinglinkItem($id);
        $tags = $link->tags;
        // Test if id is user_id from riinglink
        if($this->auth->id != $link->host_id)
        {
            return redirect('/');
        }

        $metas       = $this->meta->getMetas($id);
        $ringlink    = $this->riiinglink->getRiiinglinks($id,true);
        $ringlink    = $this->riiinglink->convert($ringlink, $this->auth->labels->toArray());
        $labels      = $this->riiinglink->convertToGroupLabel();
        $depedencies = $this->groupe->getDependencies($this->auth->user_type);

        return view('backend.link')->with( $depedencies + array('user' => $this->auth,'ringlink' => $ringlink, 'tags' => $tags, 'metas' => $metas , 'labels' => $labels));
    }

}
