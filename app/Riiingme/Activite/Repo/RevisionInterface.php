<?php namespace App\Riiingme\Activite\Repo;


interface RevisionInterface{

    public function getUpdatedUser($period);
    public function changes($user_id, $period = null);
    public function delete($id);

}