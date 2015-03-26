<?php namespace App\Riiingme\Country\Entities;

class Country extends \Eloquent{

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
    protected $fillable = array('iso','name','nicename','iso3','numcode','phonecode');

}