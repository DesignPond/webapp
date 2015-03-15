<?php

use Riiingme\User\Repo\UserInterface;

class SearchController extends \BaseController {

	protected $user;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	public function search()
	{

		$results = $this->user->search(Input::get('term'));

		return $this->convertAutocomplete($results);

	}

	public function convertAutocomplete($results){

		$data = [];

		if(!$results->isEmpty()){
			foreach($results as $result){
				$new    = ['label' => $result->email,'value' =>  $result->email];
				$data[] = $new;
			}
		}

		return $data;

	}

}
