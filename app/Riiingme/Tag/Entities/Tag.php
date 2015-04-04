<?php namespace App\Riiingme\Tag\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	protected $guarded = array('id');
	public $timestamps = false;

	public function riiinglink_tags()
    {
        return $this->belongsToMany('App\Riiingme\Riiinglink\Entities\Riiinglink', 'riiinglink_tags', 'tag_id', 'riiinglink_id');
    }
    
}
