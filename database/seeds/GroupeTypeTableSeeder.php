<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GroupeTypeTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{
		DB::table('groupe_type')->truncate();

        //  $table->enum('user_type', array('private', 'company'));

		$groupe_type = array(
			array( 'groupe_id' => 1, 'type_id' => 1 ),
			array( 'groupe_id' => 1, 'type_id' => 12 ),

            array( 'groupe_id' => 2, 'type_id' => 1 ),
			array( 'groupe_id' => 2, 'type_id' => 4 ),
			array( 'groupe_id' => 2, 'type_id' => 5 ),
			array( 'groupe_id' => 2, 'type_id' => 6 ),
			array( 'groupe_id' => 2, 'type_id' => 7 ),
			array( 'groupe_id' => 2, 'type_id' => 8 ),
			array( 'groupe_id' => 2, 'type_id' => 9 ),
			array( 'groupe_id' => 2, 'type_id' => 10 ),
			array( 'groupe_id' => 2, 'type_id' => 11 ),

			array( 'groupe_id' => 3, 'type_id' => 1 ),
            array( 'groupe_id' => 3, 'type_id' => 4 ),
			array( 'groupe_id' => 3, 'type_id' => 5 ),
			array( 'groupe_id' => 3, 'type_id' => 6 ),
			array( 'groupe_id' => 3, 'type_id' => 7 ),
			array( 'groupe_id' => 3, 'type_id' => 8 ),
			array( 'groupe_id' => 3, 'type_id' => 9 ),
			array( 'groupe_id' => 3, 'type_id' => 11 ),

            array( 'groupe_id' => 4, 'type_id' => 4 ),
            array( 'groupe_id' => 4, 'type_id' => 5 ),
            array( 'groupe_id' => 4, 'type_id' => 6 ),
            array( 'groupe_id' => 4, 'type_id' => 7 ),
            array( 'groupe_id' => 4, 'type_id' => 8 ),
            array( 'groupe_id' => 4, 'type_id' => 9 ),
            array( 'groupe_id' => 4, 'type_id' => 10 ),
            array( 'groupe_id' => 4, 'type_id' => 11 ),

            array( 'groupe_id' => 5, 'type_id' => 1 ),
            array( 'groupe_id' => 5, 'type_id' => 4 ),
            array( 'groupe_id' => 5, 'type_id' => 5 ),
            array( 'groupe_id' => 5, 'type_id' => 6 ),
            array( 'groupe_id' => 5, 'type_id' => 7 ),
            array( 'groupe_id' => 5, 'type_id' => 8 ),
            array( 'groupe_id' => 5, 'type_id' => 9 ),
            array( 'groupe_id' => 5, 'type_id' => 11 ),
		);

		// Uncomment the below to run the seeder
		DB::table('groupe_type')->insert($groupe_type);
	}

}