<?php

class UserTypesGroupesTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{

        DB::table('user_types_groupes')->truncate();

        $types = array(
            array( 'user_type_id' => 1, 'groupe_id' => 1),
            array( 'user_type_id' => 1, 'groupe_id' => 2),
            array( 'user_type_id' => 1, 'groupe_id' => 3),
            array( 'user_type_id' => 1, 'groupe_id' => 4),
            array( 'user_type_id' => 1, 'groupe_id' => 5),
            array( 'user_type_id' => 2, 'groupe_id' => 1),
            array( 'user_type_id' => 2, 'groupe_id' => 6),
            array( 'user_type_id' => 2, 'groupe_id' => 7)
        );

        // Uncomment the below to run the seeder
        DB::table('user_types_groupes')->insert($types);
	}

}
