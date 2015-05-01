<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model {

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('revisionable_type', 'revisionable_id', 'user_id', 'key','old_value','new_value');

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
     * Metas belongs to one label
     *
     * @var query
     */
    public function label(){

        return $this->hasOne('App\Riiingme\Label\Entities\Label', 'id', 'revisionable_id');
    }

}
