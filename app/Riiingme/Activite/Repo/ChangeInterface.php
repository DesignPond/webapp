<?php namespace App\Riiingme\Activite\Repo;


interface ChangeInterface{

    public function getAll($period);
    public function getUpdated($user_id,$period);
    public function getUserUpdates($user_id,$riiinglink_id,$period);
    public function getLastChanges();
    public function find($id);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);

}