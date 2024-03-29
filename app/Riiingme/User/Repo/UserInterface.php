<?php namespace App\Riiingme\User\Repo;

interface UserInterface {

    public function getAll($period = null);
    public function find($id);
    public function simpleFind($id);
    public function search($term);
    public function findByEmail($email);
    public function activate($token);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);
}