<?php

class ExportTest extends TestCase {

    protected $worker;

    public function setUp()
    {
        parent::setUp();

        $this->worker   = \App::make('App\Riiingme\Export\Worker\ExportWorker');

    }

    public function tearDown()
    {
        Mockery::close();
    }

	public function testSetUser()
	{
		$this->worker->setUser(1);

        $user = $this->worker->user;

		$this->assertEquals(1, $user);
	}

    public function testUnsetHiddenTypes()
    {
        $types = [1,2,3,4,5,6,12];

        $this->worker->types = $types;

        $this->worker->unsetHiddenTypes();

        $expect = [1,2,3,4,5,6];

        $this->assertEquals($this->worker->types, $expect);
    }

    public function testSetUserLabels()
    {
        $invite = new \App\Riiingme\Invite\Entities\invite;

        $label1 = new \App\Riiingme\Label\Entities\Label;
        $label1->groupe_id = 2;
        $label1->type_id   = 1;
        $label1->label     = 'label 1';
        $label2 = new \App\Riiingme\Label\Entities\Label;
        $label2->groupe_id = 2;
        $label2->type_id   = 2;
        $label2->label     = 'label 2';
        $label3 = new \App\Riiingme\Label\Entities\Label;
        $label3->groupe_id = 3;
        $label3->type_id   = 1;
        $label3->label     = 'label 3';

        $invite->labels = new \Illuminate\Database\Eloquent\Collection([$label1,$label2,$label3]);

        $invite->name = 'Cindy Leschaud';

        $actual = $this->worker->userLabelsInGroupes($invite);

        $expect = [
            2 => [
                0 => 'Cindy Leschaud',
                1 => 'label 1',
                2 => 'label 2'
            ],
            3 => [
                0 => 'Cindy Leschaud',
                1 => 'label 3',
            ]
        ];

        $this->assertEquals($actual, $expect);
    }
}
