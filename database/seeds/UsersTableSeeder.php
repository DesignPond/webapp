<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        Riiingme\User\Entities\User::create([
            'email'      => 'cindy.leschaud@gmail.com',
            'first_name' => 'Cindy',
            'last_name'  => 'Leschaud',
            'password'   => Hash::make('cindy2')
        ]);

        Riiingme\User\Entities\User::create([
            'email'      => 'coralie.95@hotmail.com',
            'first_name' => 'Coralie',
            'last_name'  => 'Leschaud',
            'password'   => Hash::make('cindy2')
        ]);

        Riiingme\User\Entities\User::create([
            'email'      => 'celine.bensmida@gmail.com',
            'first_name' => 'Céline',
            'last_name'  => 'Leschaud',
            'password'   => Hash::make('cindy2')
        ]);

        Riiingme\User\Entities\User::create([
            'email'      => 'cyrilus1987@live.fr',
            'first_name' => 'Cyril',
            'last_name'  => 'Leschaud',
            'password'   => Hash::make('cindy2')
        ]);

        for( $x = 1 ; $x < 21; $x++ )
        {
            Riiingme\User\Entities\User::create(array(
                'email'      => $faker->companyEmail,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'password'   => Hash::make('1234')
            ));
        }

	}

}
