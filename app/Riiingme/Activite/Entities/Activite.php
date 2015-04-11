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
                if($this->invited_id == null)
                {
                    return ['color' => 'warning', 'quoi' => 'Invitation envoyé à', 'qui' => $this->invite->email];
                }
                else
                {
                    return ['color' => 'success', 'quoi' => 'Invitation accepté par', 'qui' => $this->invited->name];
                }
            }
            else
            {
                return ['color' => 'primary', 'quoi' => 'Invitation de', 'qui' => $this->host->name.' accepté'];
            }
        }

        if($this->name == 'created_riiinglink'){

            if($this->user_id == \Auth::user()->id)
            {
                return ['color' => 'success', 'quoi' => 'Vous partagez avec', 'qui' => $this->invited->name];
            }
            else
            {
                return ['color' => 'success', 'quoi' => 'Nouveau partage', 'qui' => $this->host->name.' partage avec vous'];
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
