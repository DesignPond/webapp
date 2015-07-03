<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{
		$faker = Faker::create();

        $date  = \Carbon\Carbon::now();

       App\Riiingme\User\Entities\User::create([
            'email'      => 'cindy.leschaud@gmail.com',
            'first_name' => 'Cindy',
            'last_name'  => 'Leschaud',
            'user_type'  => 1,
            'password'   => Hash::make('cindy2'),
            'activation_token' => md5('cindy.leschaud@gmail.com'.$date)
        ]);

        App\Riiingme\User\Entities\User::create([
            'email'      => 'coralie.95@hotmail.com',
            'first_name' => 'Coralie',
            'last_name'  => 'Leschaud',
            'user_type'  => 1,
            'password'   => Hash::make('cindy2'),
            'activation_token' => md5('coralie.95@hotmail.com'.$date)
        ]);

        App\Riiingme\User\Entities\User::create([
            'email'      => 'celine.bensmida@gmail.com',
            'first_name' => 'Céline',
            'last_name'  => 'Leschaud',
            'user_type'  => 1,
            'password'   => Hash::make('cindy2'),
            'activation_token' => md5('celine.bensmida@gmail.com'.$date)
        ]);

        App\Riiingme\User\Entities\User::create([
            'email'      => 'cyrilus1987@live.fr',
            'first_name' => 'Cyril',
            'last_name'  => 'Leschaud',
            'user_type'  => 1,
            'password'   => Hash::make('cindy2'),
            'activation_token' => md5('cyrilus1987@live.fr'.$date)
        ]);

        for( $x = 1 ; $x < 11; $x++ )
        {
            $email = $faker->companyEmail;

            App\Riiingme\User\Entities\User::create(array(
                'email'      => $email,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'user_type'  => 1,
                'password'   => Hash::make('1234'),
                'activation_token' => md5($email.$date)
            ));
        }

        for( $x = 11 ; $x < 21; $x++ )
        {
            $email = $faker->companyEmail;

            App\Riiingme\User\Entities\User::create(array(
                'email'      => $email,
                'company'    => $faker->company,
                'user_type'  => 2,
                'password'   => Hash::make('1234'),
                'activation_token' => md5($email.$date)
            ));
        }

	}

}
