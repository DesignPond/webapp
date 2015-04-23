<?php

use Illuminate\Database\Seeder;

class GroupesTableSeeder extends Seeder {

	public function run()
	{
        DB::table('groupes')->truncate();

        $groupes = array(
            array('titre' => 'Informations' , 'status' => 'principal'),
            array('titre' => 'Adresse privé' , 'status' => 'principal'),
            array('titre' => 'Adresse professionnelle' , 'status' => 'principal'),
            array('titre' => 'Adresse privé' , 'status' => 'temporaire'),
            array('titre' => 'Adresse professionnelle' , 'status' => 'temporaire'),
            array('titre' => 'Adresse entreprise' , 'status' => 'principal'),
        );

        // Uncomment the below to run the seeder
        DB::table('groupes')->insert($groupes);
	}

}
