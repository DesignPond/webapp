<?php

class LabelWorkerTest extends TestCase {

    protected $mock;
    protected $command;
    protected $send;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->worker = \App::make('App\Riiingme\Label\Worker\LabelWorker');

        $this->mock   = $this->mock('App\Riiingme\Label\Worker\LabelWorker');
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    public function tearDown()
    {
        Mockery::close();
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testConvertLabels()
	{
        $inputs = [
            1 => 'Unine',
            2 => 'DesignPond' ,
            5 => ''
        ];

        $actual = $this->worker->convertLabels($inputs,1,2); // $inputs, $user_id, $groupe, $date = null

        $expected = [
            ['label' => 'Unine',  'user_id' => 1,   'groupe_id' => 2, 'type_id' => 1],
            ['label' => 'DesignPond', 'user_id' => 1, 'groupe_id' => 2, 'type_id' => 2],
        ];

        $this->assertEquals($expected, $actual);

	}

    public function testAssignPhotoUser()
    {
        $user_id = 1;
        $label   = 'cindy.jpg';
        $id      = 1;

       // $this->mock->updatePhoto($user_id,$label,$id);
        $response = $this->call('POST', 'upload', [ 'user_id'  => 1 , '_token' => Session::token() , 'photo' => 'cindy.jpg', 'label_id' => 1 ]);

        $this->mock->shouldReceive('updatePhoto')->with($user_id,$label,$id)->once();

    }

}
