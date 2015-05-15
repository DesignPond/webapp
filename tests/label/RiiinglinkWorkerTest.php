<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class RiiinglinkWorkerTest extends TestCase {

    protected $mock;
    protected $worker;
    protected $meta;
    protected $stub;
    protected $link;

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
        $this->link   = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
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
        \DB::table('invites')->truncate();
        \DB::table('riiinglinks')->truncate();
        $this->seed('RiiinglinksTableSeeder');
        \DB::table('metas')->truncate();
        $this->seed('MetasTableSeeder');
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testSetMetas()
	{

        $new = [ 3 => [ 6 => 16 , 3 => 13 , 7 => 17]];

        $this->worker->setMetasForRiiinglink($this->stub->riiinglink_id,$new);

        $actual = $this->meta->findByRiiinglink($this->stub->riiinglink_id);

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

       $this->assertEquals($expected, unserialize($actual->first()->labels));

	}

    public function testUpdateMetas()
    {

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

        $object = new stdClass();
        $object->labels = serialize($metas);

        $new = [ 3 => [ 6 => 16 , 3 => 13 , 7 => 17]];

        $actual = $this->worker->updateMetas($object,$new);

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

        $this->assertEquals($expected, $actual);

    }

    public function testSyncLabels()
    {
        list($link1 , $link2) = $this->link->create(['host_id' => 1, 'invited_id' => 24]);

        $metas = [ 2 => [ 1, 4, 5 ],  3 => [ 1, 6 ] ];

        $before = [];

        $this->assertEquals($before,[]);

        $expected  =  [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                6 => 16
            ]
        ];

        $this->worker->syncLabels($link1, $metas);

        $riinglink = $this->link->find($link1->id)->first();

        $actual    = unserialize($riinglink->usermetas->labels);

        $this->assertEquals($expected,$actual);
    }

}
