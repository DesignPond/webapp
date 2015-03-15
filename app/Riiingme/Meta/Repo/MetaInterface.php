<?php namespace App\Riiingme\Meta\Repo;

interface MetaInterface {

    public function getAll();
    public function find($id);
    public function findByRiiinglink($riiinglink);
    public function create(array $data);
    public function delete($id);
}