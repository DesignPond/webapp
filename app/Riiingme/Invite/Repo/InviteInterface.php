<?php namespace App\Riiingme\Invite\Repo;

interface InviteInterface{

    public function getAll($user_id);
    public function getPending($user_id);
    public function find($id);
    public function validate($token);
    public function setToken($id);
    public function create(array $data);
    public function delete($id);

}