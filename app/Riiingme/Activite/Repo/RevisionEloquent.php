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
            ->from(\DB::raw(
                'revisions NATURAL JOIN (
                SELECT   user_id, MAX(created_at) created_at
                FROM     revisions
                GROUP BY revisionable_id
            ) t'
            ))
            ->where('new_value','!=','')
            ->where('user_id','=',$user_id)
            ->period($period)
            ->with(['label'])
            ->get();

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
