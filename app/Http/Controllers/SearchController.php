<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Riiingme\User\Repo\UserInterface;

class SearchController extends Controller {

	protected $user;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	public function search(Request $request)
	{

		$results = $this->user->search($request->input('term'));

		return $this->convertAutocomplete($results);

	}

	public function convertAutocomplete($results){

		$data = [];

		if(!$results->isEmpty()){
			foreach($results as $result){
				$new    = ['label' => $result->name , 'desc' => $result->email , 'value' =>  $result->email, 'id' =>  $result->id, 'user_type' => $result->user_type];
				$data[] = $new;
			}
		}

		return $data;

	}

}
