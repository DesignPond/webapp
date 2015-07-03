<?php

class ChangeWorkerTest extends TestCase {

    protected $worker;
    protected $revision;
    protected $change;
    protected $label;
    protected $meta;

    public function setUp()
    {
        parent::setUp();

        $this->createApplication();

        $user = App\Riiingme\User\Entities\User::find(1);
        $this->be($user);

        $this->revision = \Mockery::mock('App\Riiingme\Activite\Repo\RevisionInterface');
        $this->app->instance('App\Riiingme\Activite\Repo\RevisionInterface', $this->revision);

        $this->change = \Mockery::mock('App\Riiingme\Activite\Repo\ChangeInterface');
        $this->app->instance('App\Riiingme\Activite\Repo\ChangeInterface', $this->change);

        $this->label = \Mockery::mock('App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer');
        $this->app->instance('App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer', $this->label);


        $this->worker = new \App\Riiingme\Activite\Worker\ChangeWorker(
            $this->change,
            \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface'),
            \App::make('App\Riiingme\Label\Worker\LabelWorker'),
            \App::make('App\Riiingme\User\Repo\UserInterface'),
            $this->label,
            $this->revision,
            \App::make('App\Riiingme\Meta\Repo\MetaInterface')
        );
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    public function testSetUser(){

        $this->worker->setUser(1);

        $expected = 1;
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

        $this->revision->shouldReceive('changes')->once()->with(1,'week')->andReturn(new Illuminate\Database\Eloquent\Collection);

        $response = $this->worker->getLabelChanges();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $response);
    }

    public function testGetUserChangesAndRevision(){

        $this->worker->setUser(1);
        $this->worker->setPeriod('week');

        $this->change->shouldReceive('getAll')->once()->with('week')->andReturn(new Illuminate\Database\Eloquent\Collection);
        $this->revision->shouldReceive('getUpdatedUser')->once()->with('week')->andReturn(new Illuminate\Database\Eloquent\Collection);

        $response = $this->worker->getUsersHaveUpdate();

        $this->assertTrue(is_array($response));
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

            $change->name  = 'updated_meta';
            $change2->name = 'updated_meta';

            $this->worker->updates = new Illuminate\Database\Eloquent\Collection([$change2,$change]);

            //$response = $this->worker->setUser(1)->setPeriod('week')->getChanges();

            //$this->assertEquals($item['result'], $response);
        }
    }

    public function testDeletedChangesOnly()
    {
        $change   = new App\Riiingme\Activite\Entities\Change;
        $change2  = new App\Riiingme\Activite\Entities\Change;

        $change->labels  = serialize([ 3 => [ 6 => 16 , 3 => 13 ] ]);
        $change2->labels = serialize([ 3 => [ 3 => 13 ] ]);

        $change->name  = 'updated_meta';
        $change2->name = 'updated_meta';

        $this->worker->updates = new Illuminate\Database\Eloquent\Collection([$change2,$change]);

  /*      $difference = $this->worker->setUser(1)->setPeriod('week')->setPart('deleted')->getChanges();

        $this->label->shouldReceive('getLabels')->once()->with($difference['deleted'],true)->andReturn([3 => [ 6 => '2000']]);

        $response = $this->worker->convertToLabels($difference);

        $this->assertEquals( [ 3 => [ 6 => '2000' ]] , $response);

        $difference = $this->worker->setUser(1)->setPeriod('week')->setPart('added')->getChanges();
        $response   = $this->worker->convertToLabels($difference);

        $this->assertEquals([] , $response);*/
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

    public function testRemoveDuplicates(){

        $revisions = [
            3 => [6 => 16, 3 => 13, 7 => 17]
        ];

        $changes = [
            2 => [1 => 2, 4 => 3, 5 => 4],
            3 => [6 => 16, 3 => 13,]
        ];

        $actual = $this->worker->removeDuplicates($changes, $revisions);

        $expected = [3 => [7 => 17]];

        $this->assertEquals($expected, $actual);

        $revisions2 = [
            3 => [6 => 16, 3 => 13, 7 => 17],
            2 => [1 => 2, 4 => 3, 5 => 4]
        ];

        $changes2 = [
            3 => [6 => 16, 3 => 13,]
        ];

        $actual2 = $this->worker->removeDuplicates($changes2, $revisions2);

        $expected2 = [3 => [7 => 17], 2 => [1 => 2, 4 => 3, 5 => 4]];

        $this->assertEquals($expected2, $actual2);

        $revisions3 = [
            3 => [6 => 16, 3 => 13, 7 => 17],
            2 => [1 => 2, 4 => 3, 5 => 4]
        ];

        $changes3 = [];

        $actual3 = $this->worker->removeDuplicates($changes3, $revisions3);

        $expected3 = [
            3 => [6 => 16, 3 => 13, 7 => 17],
            2 => [1 => 2, 4 => 3, 5 => 4]
        ];

        $this->assertEquals($expected3, $actual3);

        $revisions4 = [];

        $changes4 = [
            3 => [6 => 16, 3 => 13, 7 => 17],
            2 => [1 => 2, 4 => 3, 5 => 4]
        ];

        $actual4 = $this->worker->removeDuplicates($changes4, $revisions4);

        $expected4 = [];

        $this->assertEquals($expected4, $actual4);

    }

}
