<?php

class ChangeWorkerTest extends TestCase {

    protected $worker;
    protected $mock;

    public function setUp()
    {
        parent::setUp();

        $this->refreshApplication();

        $this->worker = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');

        $this->mock = Mockery::mock('App\Riiingme\Activite\Repo\RevisionInterface');
        $this->app->instance('App\Riiingme\Activite\Repo\RevisionInterface', $this->mock);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetChanges(){

        $this->mock->shouldReceive('getChanges')->once()->with([ 'user_id' => 1, 'period' => 'week' ])->andReturn(new Illuminate\Database\Eloquent\Collection);

        $response = $this->worker->getLabelChanges(1, 'week');

        $this->assertEquals(200, $response->getStatusCode());

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
