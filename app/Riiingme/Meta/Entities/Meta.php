<?php namespace App\Riiingme\Meta\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Riiingme\Traits\RecordsChanges;

class Meta extends Model{

    use RecordsChanges;

    protected static $recordEvents = ['created','updated','deleted'];

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
    protected $fillable = array('riiinglink_id', 'labels');

    /**
     * Metas belongs to one label
     *
     * @var query
     */
    public function labels(){

        return $this->hasOne('App\Riiingme\Label\Entities\Label', 'id', 'label_id');
    }

    /**
     * Metas belongs to multiple riiinglinks
     *
     * @var query
     */
    public function riiinglink(){

        return $this->belongsTo('App\Riiingme\Riiinglink\Entities\Riiinglink');
    }


}