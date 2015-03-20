<?php namespace App\Riiingme\User\Entities;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_types';

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
    protected $fillable = array('type');

}