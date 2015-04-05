<?php namespace App\Riiingme\Tag\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	protected $guarded = array('id');
	public $timestamps = false;

	public function riiinglink_tags()
    {
        return $this->belongsToMany('App\Riiingme\Riiinglink\Entities\Riiinglink', 'riiinglink_tags', 'tag_id', 'riiinglink_id');
    }

    public function user_tags()
    {
        return $this->belongsToMany('App\Riiingme\User\Entities\User', 'user_tags', 'tag_id', 'user_id');
    }
    
}
