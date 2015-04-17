<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Meta\Worker\MetaWorker;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Activite\Worker\ActiviteWorker;

class RiiinglinkController extends Controller {

    protected $riiinglink;
    protected $user;
    protected $meta;
    protected $groupe;
    protected $activity;

    public function __construct(UserInterface $user, MetaWorker $meta, GroupeWorker $groupe, RiiinglinkWorker $riiinglink, ActiviteWorker $activity)
    {
        $this->middleware('auth');
        $this->middleware('autorized', ['only' => ['show']]);

        $this->user       = $user;
        $this->meta       = $meta;
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;
        $this->activity   = $activity;

        $this->auth = $this->user->find(\Auth::user()->id);

        $demandes = $this->activity->getAskInvites($this->auth->email);
        \View::share('demandes', $demandes);
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
        $metas       = $this->meta->getMetas($id);
        $ringlink    = $this->riiinglink->getRiiinglinkPrepared($id);
        $depedencies = $this->groupe->getDependencies($this->auth->user_type);
        $ringlink    = $this->riiinglink->convert($ringlink, $this->auth->labels->toArray());

        return view('backend.link')->with( $depedencies + array('user' => $this->auth, 'ringlink' => $ringlink, 'metas' => $metas ));
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /riiinlink/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->riiinglink->destroy($id);
    }

}
