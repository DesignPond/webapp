<?php namespace Schema\Tag\Entities;

use Schema\Common\BaseModel as BaseModel;

class Projet_tag extends BaseModel {

	protected $guarded = array('id');
	public $timestamps = false;

    /**
     * Validation rules
     *
     * @var array
     */
    protected static $rules = array(

    );

    /**
     * Validation messages
     *
     * @var array
     */
    protected static $messages = array(

    );

    
}
