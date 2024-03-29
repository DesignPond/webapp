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

    public function testSetAllTypes()
    {
        $data_groupe = [
            1 => 'label 1',
            2 => 'label 2',
            3 => 'label 3',
            4 => 'label 4',
            5 => 'label 5'
        ];

        $groupes = $this->worker->typeForGroupes($data_groupe,[2,3,4]);

        $actual = [
            0 => '',
            2 => 'label 2',
            3 => 'label 3',
            4 => 'label 4',
        ];

        $this->assertEquals($actual,$groupes);
    }

    public function testPeriodRangeInEffect()
    {
        $start = \Carbon\Carbon::now()->toDateString();
        $end   = \Carbon\Carbon::now()->addWeeks(2)->toDateString();

        $users_groups1  = new App\Riiingme\User\Entities\User_group();
        $users_groups2  = new App\Riiingme\User\Entities\User_group();

        $users_groups1->groupe_id = 4;
        $users_groups1->start_at  = $start;
        $users_groups1->end_at    = $end;
        $users_groups2->groupe_id = 5;
        $users_groups2->start_at  = '2014-11-31';
        $users_groups2->end_at    = '2014-12-31';

        $collection = new Illuminate\Database\Eloquent\Collection([$users_groups1,$users_groups2]);

        $data = [
            2 => [ 3 => 'label', 4 => 'label'],
            3 => [ 5 => 'label', 6 => 'label'],
            4 => [ 7 => 'label', 8 => 'label'],
            5 => [ 9 => 'label', 1 => 'label']
        ];

        $expect =  [
            3 => [ 5 => 'label', 6 => 'label'],
            4 => [ 7 => 'label', 8 => 'label'],
        ];

        $actual = $this->worker->periodIsInEffect($collection, $data);

        $this->assertEquals($expect,$actual);
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

    public function testOrderTypesInGroupe(){

        $groupe = [
            0 => 'Cindy Leschaud',
            3 => 'Cindy',
            5 => 'Label',
            6 => 'Last',
            9 => 'Other',
        ];

        $expect = [
            0  => 'Cindy Leschaud',
            1  => '',
            2  => '',
            3  => 'Cindy',
            4  => '',
            5  => 'Label',
            6  => 'Last',
            7  => '',
            8  => '',
            9  => 'Other',
            10 => '',
            11 => '',
            12 => ''
        ];

        $actual = $this->worker->typeForGroupes($groupe);

        $this->assertEquals($expect, $actual);
    }


    public function testOrderTypesInGroupeUnset(){

        $groupe = [
            0 => 'Cindy Leschaud',
            3 => 'Cindy',
            5 => 'Label',
            6 => 'Last',
            9 => 'Other',
        ];

        $expect = [
            0  => 'Cindy Leschaud',
            1  => '',
            2  => '',
            3  => 'Cindy',
            4  => '',
            5  => 'Label',
            6  => 'Last',
            7  => '',
            8  => '',
            9  => 'Other',
            10 => '',
            11 => '',
        ];

        $actual = $this->worker->typeForGroupes($groupe,[1,2,3,4,5,6,7,8,9,10,11]);

        $this->assertEquals($expect, $actual);
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
