<?php namespace App\Riiingme\Groupe\Repo;

interface GroupeInterface {

    public function getAll($type = null);
    public function find($id);
}