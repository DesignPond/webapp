<?php namespace App\Riiingme\Tag\Repo;

interface TagInterface {
	
	public function getAll($user_id);
	public function find($id);
	public function create(array $data);
	public function search($term);
	
}

