<?php namespace App\Riiingme\User\Repo;

interface UserInterface {

    public function getAll();
    public function find($id);
    public function search($term);
    public function findByEmail($email);
    public function activate($token);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);
}