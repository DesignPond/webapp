<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Change extends Model {

    /**
     * Dates as carbon objects
     *
     * @var array
     */
    protected $dates = ['changed_at'];

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('meta_id', 'user_id', 'riiinglink_id', 'changed_at','name');

    public function user()
    {
        return $this->belongsTo('App\Riiingme\User\Entities\User','user_id');
    }

    public function riiinglink()
    {
        return $this->belongsTo('App\Riiingme\Riiinglink\Entities\Riiinglink','riiinglink_id');
    }

}
