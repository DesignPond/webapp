<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
            $table->string('company')->nullable();
            $table->enum('user_type', array('private', 'company'));
			$table->string('password', 60);
			$table->timestamp('activated_at')->nullable();
			$table->string('activation_token', 100)->nullable();
			$table->string('remember_token',100)->nullable();
            $table->softDeletes();
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
		Schema::drop('users');
	}

}
