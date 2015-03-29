<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class RiiinglinkWorkerTest extends TestCase {

    protected $mock;
    protected $worker;

    public function setUp()
    {
        parent::setUp();

        $this->worker = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');

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
	public function testUpdateMetas()
	{
        $object = new stdClass();
        $metas = [
            2 => [1,4,5],
            3 => [1,6]
        ];

        $object->labels = serialize($metas);

        $new = [
            3 => [3,6,7]
        ];

        $actual = $this->worker->updateMetas($object,$new); // $inputs, $user_id, $groupe, $date = null

        $expected = [
            2 => [1,4,5],
            3 => [1,3,6,7]
        ];
        
        echo '<pre>';
        print_r(unserialize($actual));
        echo '</pre>';exit;

        $this->assertEquals($expected, unserialize($actual));

	}

}
