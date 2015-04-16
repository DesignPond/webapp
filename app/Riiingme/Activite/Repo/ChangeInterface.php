<?php namespace App\Riiingme\Activite\Repo;


interface ChangeInterface{

    public function getAll($user_id);
    public function find($id);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);

}