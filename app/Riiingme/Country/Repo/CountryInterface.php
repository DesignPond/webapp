<?php namespace App\Riiingme\Country\Repo;

interface CountryInterface{

    public function getAll();
    public function find($id);
    public function create(array $data);
    public function delete($id);

}