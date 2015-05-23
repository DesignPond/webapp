<?php namespace App\Riiingme\User\Entities;

use Illuminate\Database\Eloquent\Model;

class User_group extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_groups';

    /**
     * Dates as carbon objects
     *
     * @var array
     */
    protected $dates = ['end_at','start_at'];

    /**
     * No timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('user_id','groupe_id','start_at','end_at');

    public function getPeriodRangeAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_at);
        $end   = \Carbon\Carbon::parse($this->end_at);

        $now   = \Carbon\Carbon::now();

        return ($start < $now && $end > $now ? true : false);
    }
}