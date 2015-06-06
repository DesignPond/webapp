<?php namespace App\Http\Controllers;

use App\Riiingme\User\Repo\UserInterface;

class HomeController extends Controller {

    protected $user;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserInterface $user)
	{
        $this->user       = $user;
        $this->auth = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('test');
	}

}
