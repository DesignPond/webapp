<?php namespace App\Riiingme\Invite\Entities;

use App\Riiingme\Traits\RecordsActivity;

class Invite extends \Eloquent{

    use RecordsActivity;

    protected static $recordEvents = ['created','updated'];

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('email','user_id','invited_id','partage_host','partage_invited','activated_at');

    public function getUrlTokenAttribute()
    {
        $email = base64_encode($this->email);
        $url   = url('invite?token='.$this->token.'&ref='.$email.'');

        return $url;
    }

    /**
     * Labels belongs to user
     *
     * @var query
     */
    public function user(){

        return $this->belongsTo('App\Riiingme\User\Entities\User');
    }

}