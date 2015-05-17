<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class LabelWorkerTest extends TestCase {

    protected $mock;
    protected $command;
    protected $send;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user   = \App::make('App\Riiingme\User\Repo\UserInterface');
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
        \DB::table('riiinglinks')->truncate();
      //  \DB::table('user_groups')->truncate();
        $this->seed('RiiinglinksTableSeeder');
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

    public function testLabelForUser()
    {
        $inputs = [
            2 => [1],
            3 => [4,5,6]
        ];

        $actual = $this->worker->labelForUser($inputs,1); // $inputs, $user_id, $groupe, $date = null

        $expected = [
            2 => [
                1 => 2
            ],
            3 => [
                4 => 14,
                5 => 15,
                6 => 16
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testConvertPartgeUserType()
    {
        $actual1   = $this->worker->convertPartgeUserType([2 => [1,2,3]],1);
        $expected1 = [2 => [1,2,3]];

        $this->assertEquals($expected1, $actual1);

        $actual2   = $this->worker->convertPartgeUserType([2 => [4,5,10]],15);
        $expected2 = [6 => [4,5]];

        $this->assertEquals($expected2, $actual2);

        $actual3   = $this->worker->convertPartgeUserType([6 => [1,2,3]],15);
        $expected3 = [6 => [1,2,3]];

        $this->assertEquals($expected3, $actual3);
    }

    public function testSetOrUpdatePeriodRange()
    {
        $coralie = $this->user->find(2);
        $date    = '2015-03-22 | 2015-05-31';

        $this->worker->updatePeriodRange($coralie, 4, $date);

        $user = $this->user->find(2);

        $this->assertTrue($this->hasPivotGroupe($user->user_groups,4));
    }


    public function testSetNoPeriodRange()
    {
        $coralie = $this->user->find(2);

        $this->worker->updatePeriodRange($coralie, 4, null);

        $user = $this->user->find(2);

        $this->assertFalse($this->hasPivotGroupe($user->user_groups,4));
    }

    public function hasPivotGroupe($user_groups,$groupe)
    {
        if(!$user_groups->isEmpty())
        {
            foreach($user_groups as $pivot)
            {
                $groupes[] = $pivot->pivot->groupe_id;
            }

            return in_array($groupe,$groupes);
        }

        return false;
    }

    public function testAssignPhotoUser()
    {
/*        $user_id = 1;
        $id      = 1;
        $label   = 'test.jpg';
        
        $this->mock->shouldReceive('updatePhoto')->with($user_id,$label,$id)->once();

        $path     = dirname(dirname(dirname(dirname(__FILE__)))) . '/test/'; ;
        $filename = 'test.jpg';;

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile (
            $path.$filename, $filename, 'image/jpeg', '351106'
        );

        $response = $this->call('POST', 'upload', [ 'user_id'  => 1 , '_token' => csrf_token() , 'photo' => 'avatar.jpg', 'label_id' => 1 ] ,[], ['file' => $file]);

        //call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)

        echo '<pre>';
        print_r($response->getContent());
        echo '</pre>';exit;

        $this->assertTrue($response->isOk());*/
    }

}
