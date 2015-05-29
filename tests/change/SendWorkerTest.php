<?php

use Faker\Factory as Faker;

class SendWorkerTest extends TestCase {

    protected $mock;
    protected $worker;
    protected $faker;

    public function setUp()
    {
        $this->faker = Faker::create();

        parent::setUp();

        $this->worker = \App::make('App\Riiingme\Activite\Worker\SendWorker');

        $this->mock = Mockery::mock('App\Droit\User\Repo\UserInterface');
        $this->app->instance('App\Droit\User\Repo\UserInterface', $this->mock);
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testSendWorker()
	{
        $expect = [];
        $users = $this->createUsers();
       // $this->mock->shouldReceive('simpleFind')->once()->andReturn($users);
        $this->worker->setInterval('week');
        $this->worker->users = $users;
        
        $result = $this->worker->send();


       // $this->assertEquals($expect, $result);
	}

    public function createUsers()
    {

        $all = [];

        for( $x = 1 ; $x < 7; $x++ )
        {
            $user  = new App\Riiingme\User\Entities\User();

            $user->id = $x;
            $user->first_name  = $this->faker->firstName;
            $user->last_name   = $this->faker->lastName;
            $user->email       = $this->faker->email;
            $links = [];
            
            for( $y = 1 ; $y < 6; $y++ )
            {
                if($y != $x)
                {
                    $link  = new App\Riiingme\Riiinglink\Entities\Riiinglink();
                    $link->invited_id = $y;

                    $links[] = $link;
                }
            }

            $riinglinks = new Illuminate\Database\Eloquent\Collection($links);

            $user->setAttribute('riiinglinks',$riinglinks);

            $all[] = $user;
        }

        return new Illuminate\Database\Eloquent\Collection($all);

    }

}
