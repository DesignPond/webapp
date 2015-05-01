<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Change extends Model {

    /**
     * Dates as carbon objects
     *
     * @var array
     */
    protected $dates = ['changed_at'];

    public function scopePeriod($query,$period)
    {

        switch ($period) {
            case 'day':
                $subPeriod = \Carbon\Carbon::now()->subHours(24);
                break;
            case 'week':
                $subPeriod = \Carbon\Carbon::now()->subWeek();
                break;
            case 'month':
                $subPeriod = \Carbon\Carbon::now()->subMonth();
                break;
            default:
                $subPeriod = \Carbon\Carbon::now()->subMonths(6);
        }

        return $query->where('created_at', '<', \Carbon\Carbon::now())->where('created_at', '>', $subPeriod );
    }

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
