<?php

use Faker\Factory as Faker;

class LabelsTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{
		DB::table('labels')->truncate();

		$faker = Faker::create();

		$types = array(
			1 => 'email',
			2 => 'company',
			3 => 'citySuffix',
			4 => 'streetAddress',
			5 => 'postcode',
			6 => 'city',
			7 => 'country',
			8 => 'phoneNumber',
			9 => 'phoneNumber',
			10 => 'date',
			11 => 'url',
			12 => 'randomDigit'
		);

		$types = array(
			array( 'titre' => 'Email'),
			array( 'titre' => 'Entreprise'),
			array( 'titre' => 'Profession'),
			array( 'titre' => 'Rue et Numéro'),
			array( 'titre' => 'NPA'),
			array( 'titre' => 'Ville'),
			array( 'titre' => 'Pays'),
			array( 'titre' => 'Téléphone fixe'),
			array( 'titre' => 'Téléphone portable'),
			array( 'titre' => 'Date de naissance'),
			array( 'titre' => 'Site web'),
			array( 'titre' => 'Photo')
		);

		$info  = array(12);
		$prive = array(1,4,5,6,7,8,9,10,11);
		$prof  = array(1,2,3,4,5,6,7,8,9,11);

		$metas1 = array('',
            'cindy.leschaud@gmail.com',
            'DesignPond',
            'Web developpeur',
			'Ruelle de l\'hôtel de ville 3',
            '2520',
            'La Neuveville',
            'Suisse',
			'032 751 38 07',
            '078 690 00 23',
			'01/10/1982',
            'http://wwww.desingpond.ch',
            'cindy.jpg');

		$metas2 = array('',
            'cindy.leschaud@unine.ch',
            'Unine',
            'Web developpeur',
            'Faculté de droit',
			'Av. du 1er Mars 26',
            '2000','Neuchâtel',
            'Suisse',
			'032 718 21 30',
            '078 690 00 23',
			'',
            'http://wwww.unine.ch');

		$metas3 = array('',
            'coralie.leschaud@orange.ch',
            'Orange',
            'ARC',
			'La Voirde 19',
            '2735',
            'Bévilard',
            'Suisse',
			'032 318 21 40',
            '078 543 06 23',
			'09/27/1995',
            'http://wwww.orange.ch',
            'coralie.jpg');

		$metas4 = array('',
            'cyril.leschaud@bluewin.ch',
            'HNE',
            'ASSC',
			'Rue du test 234',
            '2300',
            'La Chaux-de-Fond',
            'Suisse',
			'032 987 21 40',
            '076 523 06 23',
			'06/19/1987',
            'http://wwww.hne.ch',
            'cyril.jpg');

		$metas5 = array('',
            'libelulle867@bluewin.ch',
            '',
            'Vendeuse',
			'Rue du collège 34',
            '2735',
            'Bévilard',
            'Suisse',
			'032 492 21 20',
            '079 345 06 23',
			'20/05/1984',
            '',
            '');

		foreach($info as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas1[$index],
				'user_id'   => 1,
				'type_id'   => $index,
				'groupe_id' => 1
			]);
		}

		foreach($prive as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas1[$index],
				'user_id'   => 1,
				'type_id'   => $index,
				'groupe_id' => 2
			]);
		}

		foreach($prof as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas2[$index],
				'user_id'   => 1,
				'type_id'   => $index,
				'groupe_id' => 3
			]);
		}

		foreach($info as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas3[$index],
				'user_id'   => 2,
				'type_id'   => $index,
				'groupe_id' => 1
			]);
		}

		foreach($prive as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas3[$index],
				'user_id'   => 2,
				'type_id'   => $index,
				'groupe_id' => 2
			]);
		}

        /*
         * For testing labels metas
         * */

		foreach($info as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas4[$index],
				'user_id'   => 3,
				'type_id'   => $index,
				'groupe_id' => 1
			]);
		}

        App\Riiingme\Label\Entities\Label::create([
            'label'     => 'label 1',
            'user_id'   => 3,
            'type_id'   => 4,
            'groupe_id' => 2
        ]);

        App\Riiingme\Label\Entities\Label::create([
            'label'     => 'label 2',
            'user_id'   => 3,
            'type_id'   => 5,
            'groupe_id' => 2
        ]);

        App\Riiingme\Label\Entities\Label::create([
            'label'     => 'label 3',
            'user_id'   => 3,
            'type_id'   => 6,
            'groupe_id' => 2
        ]);

        /*
         * End test
         * */


		foreach($info as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas5[$index],
				'user_id'   => 4,
				'type_id'   => $index,
				'groupe_id' => 1
			]);
		}

		foreach($prive as $index)
		{
            App\Riiingme\Label\Entities\Label::create([
				'label'     => $metas5[$index],
				'user_id'   => 4,
				'type_id'   => $index,
				'groupe_id' => 2
			]);
		}

        $types = array(
            1 => 'email',
            2 => 'company',
            3 => 'citySuffix',
            4 => 'streetAddress',
            5 => 'postcode',
            6 => 'city',
            7 => 'country',
            8 => 'phoneNumber',
            9 => 'phoneNumber',
            10 => 'date',
            11 => 'url',
            12 => 'randomDigit'
        );

		for( $x = 5 ; $x < 14; $x++ )
		{
			foreach($info as $index){

				$ext = ($index == 12 ? '.jpg' : '');

                App\Riiingme\Label\Entities\Label::create([
					'label'     => $faker->$types[$index].$ext,
					'user_id'   => $x,
					'type_id'   => $index,
					'groupe_id' => 1
				]);
			}

			foreach($prive as $index){
                App\Riiingme\Label\Entities\Label::create([
					'label'     => $faker->$types[$index],
					'user_id'   => $x,
					'type_id'   => $index,
					'groupe_id' => 2
				]);
			}

			foreach($prof as $index)
			{
                App\Riiingme\Label\Entities\Label::create([
					'label'     => $faker->$types[$index],
					'user_id'   => $x,
					'type_id'   => $index,
					'groupe_id' => 3
				]);
			}

		}

	}

}