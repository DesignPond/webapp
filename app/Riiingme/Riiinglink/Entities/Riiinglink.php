<?php namespace App\Riiingme\Riiinglink\Entities;

use App\Riiingme\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;


class Riiinglink extends Model{

    use RecordsActivity;

    protected static $recordEvents = ['created','deleted'];

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('host_id', 'invited_id');

    public function scopeHosted($query,$id)
    {
        return $query->where('host_id','=',$id)->with(array('labels'));
    }

    public function scopeInvited($query,$id)
    {
        return $query->where('invited_id','=',$id)->with(array('labels'));
    }

    /**
     * Invited infos belongs to host user through link
     *
     * @var query
     */
    public function invite(){

        return $this->belongsTo('App\Riiingme\User\Entities\User','invited_id','id');
    }

    /**
     * Invited infos belongs to host user through link
     *
     * @var query
     */
    public function host(){

        return $this->belongsTo('App\Riiingme\User\Entities\User','host_id','id');
    }

    /**
     * Metas through labels belongs to user
     *
     * @var query
     */
    public function labels(){

        return $this->belongsToMany('App\Riiingme\Label\Entities\Label', 'metas');
    }

    /**
     * Metas for riiinglink
     *
     * @var query
     */
    public function metas(){

        return $this->belongsToMany('App\Riiingme\Meta\Entities\Meta');
    }

    /**
     * Metas for riiinglink
     *
     * @var query
     */
    public function usermetas(){

        return $this->hasOne('App\Riiingme\Meta\Entities\Meta');
    }

    /**
     * Tags for riiinglink
     *
     * @var query
     */
    public function tags(){

        return $this->belongsToMany('App\Riiingme\Tag\Entities\Tag', 'riiinglink_tags', 'riiinglink_id', 'tag_id');
    }


}