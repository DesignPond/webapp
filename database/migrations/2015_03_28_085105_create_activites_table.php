<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activites', function(Blueprint $table) {
            $table->increments('id');
            $table->string('type')->index();
            $table->string('name');
            $table->integer('activite_id')->index();
            $table->integer('user_id')->nullable();
            $table->integer('invited_id')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activites');
	}

}
