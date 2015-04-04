<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiiinglinkTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('riiinglink_tags', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('riiinglink_id');
            $table->integer('tag_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('riiinglink_tags');
	}

}
