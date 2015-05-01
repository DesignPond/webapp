<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model {

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('revisionable_type', 'revisionable_id', 'user_id', 'key','old_value','new_value');


}
