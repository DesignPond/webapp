<?php

use Illuminate\Database\Seeder;

class GroupesTableSeeder extends Seeder {

	public function run()
	{
        DB::table('groupes')->truncate();

        $groupes = array(
            array('titre' => 'Informations' , 'status' => 'principal'),
            array('titre' => 'Adresse privé' , 'status' => 'principal'),//2
            array('titre' => 'Adresse professionnelle' , 'status' => 'principal'),//3
            array('titre' => 'Adresse privé' , 'status' => 'temporaire'),//4
            array('titre' => 'Adresse professionnelle' , 'status' => 'temporaire'),//5
            array('titre' => 'Adresse entreprise' , 'status' => 'principal'),//6
        );

        // Uncomment the below to run the seeder
        DB::table('groupes')->insert($groupes);
	}

}
