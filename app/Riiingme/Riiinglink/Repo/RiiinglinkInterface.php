<?php namespace App\Riiingme\Riiinglink\Repo;

interface RiiinglinkInterface {

    public function getAll();
    public function find($id);
    public function findBy($id,$scope,$nbr = null);
    public function findByHost($user_id);
    public function findByHostWithParams($user_id,$params);
    public function findByHostAndInvited($invited_id,$host_id);
    public function create(array $data);
    public function delete($id);

}