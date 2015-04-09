<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class RiiinglinkWorkerTest extends TestCase {

    protected $mock;
    protected $worker;
    protected $meta;
    protected $stub;

    public function setUp()
    {
        parent::setUp();

        $metas = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                6 => 16,
            ]
        ];

        $this->worker = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');
        $this->meta   = \App::make('App\Riiingme\Meta\Repo\MetaInterface');
        $this->stub   =  $this->meta->create([ 'riiinglink_id' => 50, 'labels' => serialize($metas) ]);
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
        \DB::table('metas')->truncate();
        $this->seed('MetasTableSeeder');
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testUpdateMetas()
	{

        $new = [ 3 => [ 6 , 3 , 7]];

        $this->worker->setMetasForRiiinglink(1,50,$new);

        $actual = $this->meta->find($this->stub->id);

        $expected = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                3 => 13,
                6 => 16,
                7 => 17
            ]
        ];

       $this->assertEquals($expected, unserialize($actual->labels));

	}

}
