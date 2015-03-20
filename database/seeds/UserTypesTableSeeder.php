<?php

class UserTypesTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{

        DB::table('user_types')->truncate();

        $types = array(
            array( 'type' => 'Privé'),
            array( 'type' => 'Entreprise')
        );

        // Uncomment the below to run the seeder
        DB::table('user_types')->insert($types);
	}

}
