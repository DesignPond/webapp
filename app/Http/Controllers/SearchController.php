<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Riiingme\User\Repo\UserInterface;

class SearchController extends Controller {

	protected $user;
    protected $helper;

	public function __construct(UserInterface $user)
	{
		$this->user    = $user;
        $this->helper  = new \App\Riiingme\Helpers\Helper;
	}

	public function search(Request $request)
	{
		$results = $this->user->search($request->input('term'));

		return $this->helper->convertAutocomplete($results);
	}

}
