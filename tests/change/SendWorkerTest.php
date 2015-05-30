<?php

use Faker\Factory as Faker;

class SendWorkerTest extends TestCase {

    protected $mock;
    protected $worker;
    protected $faker;
    protected $user;

    public function setUp()
    {
        $this->faker = Faker::create();

        parent::setUp();

        $this->refreshApplication();

        $this->worker = \App::make('App\Riiingme\Activite\Worker\SendWorker');
        $this->user   = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->mock   = \Mockery::mock('App\Riiingme\User\Repo\UserInterface');
        $this->app->instance('App\Riiingme\User\Repo\UserInterface', $this->mock);

    }

    public function tearDown(){

        \Mockery::close();
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testSendWorker()
	{
        //$users = $this->createUsers();
        //$this->mock->shouldReceive('simpleFind')->once()->andReturn($user);

        $invited = $this->user->simpleFind(2);

        $changes = [
            'added'   => [
                2 => [ 1 => 2,  4 => 3, 5 => 4 ],
                3 => [ 1 => 11]
            ],
            'deleted' => [
                3 =>  [ 3 => 13,  7 => 17 ]
            ]
        ];

        $this->worker->setInterval('week');
        $this->worker->changeForInvite = $changes;

        $result = $this->worker->prepareChangeForInvite(2);

        $expect = ['changes' => $changes, 'user' => ['name' => $invited->name, 'photo' => $invited->user_photo]];

        $this->assertEquals($expect, $result);
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
