<?php namespace App\Http\Controllers;

use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Riiinglink\Worker\ConvertWorker;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;

class HomeController extends Controller {

    protected $user;
    protected $converter;
    protected $riiinglink;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(RiiinglinkInterface $riiinglink, UserInterface $user, ConvertWorker $converter)
	{
        $this->user       = $user;
        $this->auth = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);

        $this->riiinglink = $riiinglink;
        $this->converter  = $converter;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $riiinglink = $this->riiinglink->find(1)->first();

        $this->converter->loadUserLabels($riiinglink)->prepareLabels()->metasInEffect()->convertPeriodRange()->labelsToShow();

		return view('test')->with(['labels' => $this->converter->labels]);
	}

}
