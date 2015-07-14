<?php namespace App\Riiingme\Meta\Repo;

interface MetaInterface {

    public function getAll();
    public function find($id);
    public function findAll($ids);
    public function deleteAll($ids);
    public function findByRiiinglink($riiinglink);
    public function create(array $data);
    public function delete($id);
}