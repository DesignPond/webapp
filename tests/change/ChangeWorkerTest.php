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

    public function testGetChanges(){

        $this->worker->setUser(1);
        $this->worker->setPeriod('week');

        $response = $this->worker->getLabelChanges();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $response);
    }


    public function testMergeChanges(){

        $metas = [
            3 => [
                6 => 16,
                3 => 13,
                7 => 17
            ]
        ];

        $metas    = serialize($metas);
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

    public function testMetaCompareChangesSecond(){

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
