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
        $types = [
            1 => 'Email',
            2 => 'Entreprise',
            3 => 'Profession',
            4 => 'Rue et Numéro',
            5 => 'NPA',
            6 => 'Ville',
            7 => 'Pays',
            8 => 'Téléphone fixe',
            9 => 'Téléphone portable',
            10 => 'Date de naissance',
            11 => 'Site web',
            12 => 'Photo'
        ];

        $this->worker->types = $types;

        $this->worker->unsetHiddenTypes();

        $expect = [
            1 => 'Email',
            2 => 'Entreprise',
            3 => 'Profession',
            4 => 'Rue et Numéro',
            5 => 'NPA',
            6 => 'Ville',
            7 => 'Pays',
            8 => 'Téléphone fixe',
            9 => 'Téléphone portable',
            10 => 'Date de naissance',
            11 => 'Site web'];

        $this->assertEquals($this->worker->types, $expect);
    }

    public function testPrepareTypes()
    {

        $this->worker->labels = [3,4];

        $labels = $this->worker->prepareLabelsTitle();

        $expect = [
            0 => 'Pénom et nom',
            3 => 'Profession',
            4 => 'Rue et Numéro'
        ];

        $this->assertEquals($labels, $expect);
    }

    public function testPrepareTypesAll()
    {

        $this->worker->labels = [];

        $labels = $this->worker->prepareLabelsTitle();

        $expect = [
            0 => 'Pénom et nom',
            1 => 'Email',
            2 => 'Entreprise',
            3 => 'Profession',
            4 => 'Rue et Numéro',
            5 => 'NPA',
            6 => 'Ville',
            7 => 'Pays',
            8 => 'Téléphone fixe',
            9 => 'Téléphone portable',
            10 => 'Date de naissance',
            11 => 'Site web'
        ];

        $this->assertEquals($labels, $expect);
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

        // With labels set
        $expect2 = [
            2 => [
                0 => 'Cindy Leschaud',
                1 => 'label 1'
            ],
            3 => [
                0 => 'Cindy Leschaud',
                1 => 'label 3'
            ]
        ];

        $this->worker->labels = [1];

        $actual2 = $this->worker->userLabelsInGroupes($invite);
        $this->assertEquals($actual2, $expect2);
    }
}
