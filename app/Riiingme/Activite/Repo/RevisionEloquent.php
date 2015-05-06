<?php namespace App\Riiingme\Activite\Repo;

use App\Riiingme\Activite\Repo\RevisionInterface;
use App\Riiingme\Activite\Entities\Revision as M;

class RevisionEloquent implements RevisionInterface {

    public function __construct(M $revision){

        $this->revision = $revision;
    }

    public function getUpdatedUser($period)
    {
        return $this->revision->select('user_id')->where('new_value','!=','')->period($period)->groupBy('user_id')->get();
    }

    public function changes($user_id, $period = null)
    {
        $revisions = $this->revision
            ->where('user_id','=',$user_id)
            ->where('new_value','!=','')
            ->period($period)
            ->with(['label'])
            ->groupBy('revisionable_id')->get();

        return $revisions;
    }

    public function delete($id)
    {
        $revision = $this->revision->find($id);

        if( ! $revision )
        {
            return false;
        }

        return $revision->delete($id);
    }
}
