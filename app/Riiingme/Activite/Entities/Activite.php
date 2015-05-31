<?php namespace App\Riiingme\Activite\Entities;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model {

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('type','name', 'activite_id', 'user_id','invited_id','token');

    public function getTypeActiviteAttribute()
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        if($this->name == 'updated_invite'){

            if($this->user_id == \Auth::user()->id)
            {
                $email = (isset($this->invite->name) ? $this->invite->name : '');

                if($this->invited_id == null)
                {
                    return ['color' => 'warning', 'quoi' => 'invite_send', 'qui' => $email];
                }
                else
                {
                    return ['color' => 'success', 'quoi' => 'invite_accepted', 'qui' => $email];
                }
            }
            else
            {
                return ['color' => 'primary', 'quoi' => 'invite_from', 'qui' => $this->host->name];
            }
        }

        if($this->name == 'created_riiinglink'){

            if($this->user_id == \Auth::user()->id)
            {
                return ['color' => 'success', 'quoi' => 'share_with', 'qui' => $this->invited->name];
            }
            else
            {
                return ['color' => 'success', 'quoi' => 'share_new', 'qui' => $this->host->name];
            }
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
