<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_infos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->enum('name_visibility', ['yes', 'no'])->default('yes');
            $table->enum('email_visibility', ['yes', 'no'])->default('yes');
            $table->enum('notification_interval', ['day','week','month','semester'])->default('week');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_infos');
	}

}
