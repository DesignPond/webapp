<?php namespace App\Riiingme\Groupe\Entities;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model{

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('titre', 'status');

    /**
     * types belongs to groupes
     */
    public function groupe_type()
    {
        return $this->belongsToMany('App\Riiingme\Type\Entities\Type', 'groupe_type', 'groupe_id', 'type_id');
    }

}