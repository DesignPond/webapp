<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('site.index');
	}

    /**
     * About page
     *
     * @return void
     */
    public function about()
    {
        return view('site.about');
    }

    /**
     * Contact page
     *
     * @return void
     */
    public function contact()
    {
        return view('site.contact');
    }

}
