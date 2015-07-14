<?php namespace App\Riiingme\Activite\Repo;


interface ActiviteInterface{

    public function find($id);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);
    public function deleteAll($ids);

}