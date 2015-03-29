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

        $this->worker = \App::make('App\Riiingme\Label\Worker\LabelWorker');

        $this->mock   = $this->mock('App\Riiingme\Label\Worker\LabelWorker');

        VfsStream::setup('users');
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

    public function testLabelForUser()
    {
        $inputs = [
            2 => [1],
            3 => [4,5,6]
        ];

        $actual = $this->worker->labelForUser($inputs,1); // $inputs, $user_id, $groupe, $date = null

        $expected = [2,14,15,16];

        $this->assertEquals($expected, $actual);
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
