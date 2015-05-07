<?php

class ChangeWorkerTest extends TestCase {

    protected $worker;
    protected $mock;

    public function setUp()
    {
        parent::setUp();

        //$this->refreshApplication();

        $this->worker = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');

        $this->mock = Mockery::mock('App\Riiingme\Activite\Repo\RevisionInterface');
        $this->app->instance('App\Riiingme\Activite\Repo\RevisionInterface', $this->mock);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testSetUser(){

        $this->worker->setUser(12);

        $expected = 12;
        $this->assertEquals($expected, $this->worker->user_id);
    }

    public function testSetPeriod(){

        $this->worker->setPeriod('week');

        $expected = 'week';
        $this->assertEquals($expected, $this->worker->period);
    }

    public function testSetPart(){

        $this->worker->setPart('deleted');

        $expected = 'deleted';
        $this->assertEquals($expected, $this->worker->part);
    }

    public function testGetChanges(){

        $this->worker->setUser(1);
        $this->worker->setPeriod('week');

        $response = $this->worker->getLabelChanges();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $response);
    }

    public function testGetAllChanges(){

        $change   = new App\Riiingme\Activite\Entities\Change;
        $change2  = new App\Riiingme\Activite\Entities\Change;

        $data = [
            [ 'first' => serialize([ 3 => [ 3 => 13 ] ]), 'last' => serialize([ 3 => [ 6 => 16 , 3 => 13 ] ]), 'result' => [ 'added' => [ 3 => [ 6 => 16 ]] ] ],
            [ 'first' => serialize([ 3 => [ 3 => 13 ] ]), 'last' => serialize([ 3 => [ 3 => 13 ] ]), 'result' => [] ],
            [ 'first' => serialize([ 3 => [ 3 => 13 ] ]), 'last' => '', 'result' => ['deleted' => [ 3 => [ 3 => 13 ] ]] ]
        ];

        foreach($data as $item)
        {
            $change->labels  = $item['first'];
            $change2->labels = $item['last'];

            $this->worker->updates = new Illuminate\Database\Eloquent\Collection([$change2,$change]);

            $response = $this->worker->setUser(1)->setPeriod('week')->getChanges();

            $this->assertEquals($item['result'], $response);
        }
    }

    public function testDeletedChangesOnly()
    {
        $change   = new App\Riiingme\Activite\Entities\Change;
        $change2  = new App\Riiingme\Activite\Entities\Change;

        $change->labels  = serialize([ 3 => [ 6 => 16 , 3 => 13 ] ]);
        $change2->labels = serialize([ 3 => [ 3 => 13 ] ]);

        $this->worker->updates = new Illuminate\Database\Eloquent\Collection([$change2,$change]);

        $difference = $this->worker->setUser(1)->setPeriod('week')->setPart('deleted')->getChanges();
        $response   = $this->worker->convertToLabels($difference);

        $this->assertEquals( [ 3 => [ 6 => '2000' ]] , $response);

        $difference = $this->worker->setUser(1)->setPeriod('week')->setPart('added')->getChanges();
        $response   = $this->worker->convertToLabels($difference);

        $this->assertEquals([] , $response);
    }

    public function testMergeChangesUnserializeIsEmpty(){

        $result   = unserialize('');
        $result = (isset($result[1]) ? 'ok' : true);

        $this->assertEquals(true, $result);
    }

    public function testMetaCompareChanges(){

        $metas = [
            3 => [
                6 => 16,
                3 => 13,
                7 => 17
            ]
        ];

        $new = [
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

        $actual = $this->worker->calculDiff($metas,$new);

        $expected = [
            'added'   => [
                2 => [ 1 => 2,  4 => 3, 5 => 4 ],
                3 => [ 1 => 11]
            ],
            'deleted' => [
                3 =>  [ 3 => 13,  7 => 17 ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testMetaCompareChangesMultipleGroups(){

        $metas = [
            3 => [
                6 => 16,
                3 => 13,
                7 => 17
            ]
        ];

        $new = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                6 => 16,
            ]
        ];

        $actual = $this->worker->calculDiff($metas,$new);

        $expected = [
            'added'   => [
                2 => [ 1 => 2,  4 => 3, 5 => 4 ]
            ],
            'deleted' => [
                3 =>  [ 3 => 13,  7 => 17 ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

}