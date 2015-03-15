<?php namespace App\Riiingme\Meta\Entities;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model{

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
    protected $fillable = array('riiinglink_id', 'label_id', 'labels');

    /**
     * Validation rules
     */
    protected static $rules = array(
    );

    /**
     * Validation messages
     */
    protected static $messages = array(
    );

    /**
     * Metas belongs to one label
     *
     * @var query
     */
    public function labels(){

        return $this->hasOne('App\Riiingme\Label\Entities\Label', 'id', 'label_id');
    }


}