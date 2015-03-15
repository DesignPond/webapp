<?php namespace App\Riiingme\Label\Entities;

use Illuminate\Database\Eloquent\Model;

class Label extends Model{

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
    protected $fillable = array('user_id', 'label', 'type_id', 'groupe_id');


    public function getLabelTextAttribute()
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        return ( isset($this->type_id) && $this->type_id == 11 ? \Carbon\Carbon::parse($this->label)->formatLocalized('%d %B %Y') : $this->label );
    }

    /**
     * Labels belongs to user
     *
     * @var query
     */
    public function user(){

        return $this->belongsTo('App\Riiingme\User\Entities\User');
    }

    /**
     * Labels has one to type
     *
     * @var query
     */
    public function type(){

        return $this->belongsTo('App\Riiingme\Type\Entities\Type');
    }

    /**
     * Labels belongs to one groupe
     *
     * @var query
     */
    public function groupe(){

        return $this->belongsTo('App\Riiingme\Groupe\Entities\Groupe');
    }

}