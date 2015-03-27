<?php

use Faker\Factory as Faker;

class MetasTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{
		DB::table('metas')->truncate();

		$user_1 = App\Riiingme\Label\Entities\Label::where('user_id','=',1)->get();
        $user1_labels = [];

		foreach($user_1 as $label)
		{
            $user1_labels[$label->groupe_id][$label->type_id] = $label->id;
		}

        App\Riiingme\Meta\Entities\Meta::create([
            'riiinglink_id' => 1,
            'labels'        => serialize($user1_labels)
        ]);

        /*
         * Test
         * */
        $test_labels = [
            1 => [ 12 => 1 ] ,
            2 => [
                5 => 3,
                6 => 4,
                7 => 5
            ]
        ];

        App\Riiingme\Meta\Entities\Meta::create([
            'riiinglink_id' => 2,
            'labels'        => serialize($test_labels)
        ]);

        /*
         * Test
         * */

		$user_2 = App\Riiingme\Label\Entities\Label::where('user_id','=',2)->get();

		foreach($user_2 as $label)
		{
            $user2_labels[$label->groupe_id][$label->type_id] = $label->id;
		}

        App\Riiingme\Meta\Entities\Meta::create([
            'riiinglink_id' => 4,
            'labels'        => serialize($user2_labels)
        ]);

		$user_3 = App\Riiingme\Label\Entities\Label::where('user_id','=',3)->get();

		foreach($user_3 as $label)
		{
            $user3_labels[$label->groupe_id][$label->type_id] = $label->id;
		}

        App\Riiingme\Meta\Entities\Meta::create([
            'riiinglink_id' => 5,
            'labels'        => serialize($user3_labels)
        ]);

		for( $x = 5 ; $x < 24; $x++ )
		{
			$user_0  = App\Riiingme\Label\Entities\Label::where('user_id','=',$x)->get();
			$links_0 = App\Riiingme\Riiinglink\Entities\Riiinglink::where('host_id','=',$x)->get();
            $user0_labels = [];

			foreach($links_0 as $link)
			{
				foreach($user_0 as $label)
				{
                    $user0_labels[$label->groupe_id][$label->type_id] = $label->id;
				}

                App\Riiingme\Meta\Entities\Meta::create([
                    'riiinglink_id' => $link->id,
                    'labels'        => serialize($user0_labels)
                ]);
			}
		}

		$user_1  = App\Riiingme\Label\Entities\Label::where('user_id','=',1)->get();
		$links_1 = App\Riiingme\Riiinglink\Entities\Riiinglink::where('host_id','=',1)->where('id','>',5)->get();

		foreach($links_1 as $link)
		{
            $user6_labels = [];

			foreach($user_1 as $label)
			{
                $user6_labels[$label->groupe_id][$label->type_id] = $label->id;
			}

            App\Riiingme\Meta\Entities\Meta::create([
                'riiinglink_id' => $link->id,
                'labels'        => serialize($user6_labels)
            ]);
		}

	}

}
