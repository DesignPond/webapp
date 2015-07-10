<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model {

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('type','name', 'activite_id', 'user_id','invited_id','token');

    public function getCouleurActiviteAttribute()
    {
        if($this->user_id == \Auth::user()->id)
        {
            return ($this->invited_id == null ? 'warning' : 'success');
        }
        else
        {
            return 'primary';
        }
    }

    public function getUserActiviteAttribute()
    {
        if($this->user_id == \Auth::user()->id)
        {
            if($this->name == 'updated_invite')
            {
                if($this->invited_id == null)
                {
                    return ['quoi' => 'invite_send', 'qui' => $this->invite->email];
                }
                else
                {
                    return ['quoi' => 'invite_accepted', 'qui' => $this->invited->name];
                }
            }

            if($this->name == 'created_riiinglink')
            {
                return ['quoi' => 'share_with', 'qui' => $this->invited->name];
            }
        }
        else
        {
            if($this->name == 'created_riiinglink')
            {
                return ['quoi' => 'invite_from', 'qui' => $this->host->name];
            }
            //return ['quoi' => 'invite_from', 'qui' => $this->host->name];
        }
    }

    public function invited()
    {
        return $this->belongsTo('App\Riiingme\User\Entities\User','invited_id');
    }

    public function host()
    {
        return $this->belongsTo('App\Riiingme\User\Entities\User','user_id');
    }

    public function invite()
    {
        return $this->belongsTo('App\Riiingme\Invite\Entities\Invite','activite_id');
    }

}
