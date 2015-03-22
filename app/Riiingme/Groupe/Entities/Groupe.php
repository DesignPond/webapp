<?php namespace App\Riiingme\Groupe\Entities;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model{

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('titre', 'status');


    public function getStartAttribute()
    {
        $date = \Carbon\Carbon::parse($this->pivot->start_at)->toDateString();
        return $date;
    }

    public function getEndAttribute()
    {
        $date = \Carbon\Carbon::parse($this->pivot->end_at)->toDateString();
        return $date;
    }

    /**
     * types belongs to groupes
     */
    public function groupe_type()
    {
        return $this->belongsToMany('App\Riiingme\Type\Entities\Type', 'groupe_type', 'groupe_id', 'type_id');
    }

    /**
     * types belongs to groupes
     */
    public function user_types()
    {
        return $this->belongsToMany('App\Riiingme\User\Entities\User_type', 'user_types_groupes', 'groupe_id', 'user_type_id');
    }

}