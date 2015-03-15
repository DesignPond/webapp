<?php namespace App\Riiingme\Invite\Entities;

class Invite extends \Eloquent{

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('email','user_id','partage_host','partage_invited');

    /**
     * Validation rules
     */
    protected static $rules = array();

    /**
     * Validation messages
     */
    protected static $messages = array();

    /**
     * Labels belongs to user
     *
     * @var query
     */
    public function user(){

        return $this->belongsTo('App\Riiingme\User\Entities\User');
    }

}