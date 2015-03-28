<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class RiiinglinksTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{

        App\Riiingme\Riiinglink\Entities\Riiinglink::create([
            'host_id'    => 1,
            'invited_id' => 2,
        ]);

        App\Riiingme\Riiinglink\Entities\Riiinglink::create([
            'host_id'    => 1,
            'invited_id' => 3,
        ]);

        App\Riiingme\Riiinglink\Entities\Riiinglink::create([
            'host_id'    => 1,
            'invited_id' => 4,
        ]);

        App\Riiingme\Riiinglink\Entities\Riiinglink::create([
            'host_id'    => 2,
            'invited_id' => 1,
        ]);

        App\Riiingme\Riiinglink\Entities\Riiinglink::create([
            'host_id'    => 3,
            'invited_id' => 1,
        ]);

        for( $x = 5 ; $x < 13; $x++ )
        {

            App\Riiingme\Riiinglink\Entities\Riiinglink::create([
                'host_id'    => 1,
                'invited_id' => $x,
            ]);

            App\Riiingme\Riiinglink\Entities\Riiinglink::create([
                'host_id'    => $x,
                'invited_id' => 1,
            ]);

        }

    }

}
