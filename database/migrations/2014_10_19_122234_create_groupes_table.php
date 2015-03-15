<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groupes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('titre');
            $table->enum('status', array('principal', 'temporaire'));
            $table->dateTime('start_at');
            $table->dateTime('end_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groupes');
	}

}
