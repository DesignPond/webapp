<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\User\Repo\UserInterface;

class RiiinglinkController extends Controller {

    protected $riiinglink;
    protected $user;

    public function __construct(UserInterface $user, RiiinglinkWorker $riiinglink)
    {
        $this->middleware('auth');

        $this->user       = $user;
        $this->riiinglink = $riiinglink;

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

}
