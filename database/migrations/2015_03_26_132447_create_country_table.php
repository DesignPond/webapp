<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('iso')->nullable();
            $table->string('name');
            $table->string('nicename');
            $table->string('iso3')->nullable();
            $table->integer('numcode')->nullable();
            $table->integer('phonecode')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}
