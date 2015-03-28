<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model {

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('type','name', 'activite_id', 'user_id','invited_id');

    public function invited()
    {
        return $this->belongsTo('App\Riiingme\User\Entities\User','invited_id');
    }

    public function host()
    {
        return $this->belongsTo('App\Riiingme\User\Entities\User','user_id');
    }

    public function invite()
    {
        return $this->belongsTo('App\Riiingme\Invite\Entities\Invite','activite_id');
    }

}
