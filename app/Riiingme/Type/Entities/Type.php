<?php namespace App\Riiingme\Type\Entities;

use Illuminate\Database\Eloquent\Model;

class Type extends Model{

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
    protected $fillable = array('titre');

}