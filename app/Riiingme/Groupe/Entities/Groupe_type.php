<?php namespace App\Riiingme\Groupe\Entities;

use Illuminate\Database\Eloquent\Model;

class Groupe_type extends Model{

	protected $fillable = array('groupe_id', 'type_id');

	/**
	 * No timestamps
	 *
	 * @var boolean
	 */
	public $timestamps = false;

}