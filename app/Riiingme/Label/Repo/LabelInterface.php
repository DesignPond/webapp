<?php namespace App\Riiingme\Label\Repo;

interface LabelInterface {

    public function find($id);
    public function findByUser($user);
    public function findInfosByUser($user);
    public function findPhotoByUser($user);
    public function findByUserGroupeType($user,$groupe,$type);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);
    public function deleteAll($ids);

}