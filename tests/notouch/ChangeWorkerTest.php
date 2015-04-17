<?php

class ChangeWorkerTest extends TestCase {

    protected $worker;

    public function setUp()
    {
        parent::setUp();

        $this->worker = \App::make('App\Riiingme\Activite\Worker\ChangeWorker');
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

        $expected = true;

        $this->assertEquals($expected, $actual);
    }

}
