<?php namespace App\Riiingme\Tag\Repo;

interface TagInterface {
	
	public function getAll($user_id);
	public function find($id);
	public function create(array $data);
	public function getAllTagsForProjets($tags);
	public function dropChildren();
	public function droplist();
	public function search($term);
	
}

