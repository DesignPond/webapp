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

        $this->worker->setTypes();

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
            11 => 'Site web'
        ];

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
        $link   = new \App\Riiingme\Riiinglink\Entities\Riiinglink();
        $invite = new \App\Riiingme\Invite\Entities\Invite();

        $labels = [
            2 => [
                1 => 'label 1',
                2 => 'label 2',
                3 => 'label 3',
                4 => 'label 4',
                5 => 'label 5'
            ],
            3 => [
                1 => 'label 3',
            ]
        ];

        $link->labels  = new \Illuminate\Database\Eloquent\Collection($labels);
        $invite->name  = 'Cindy Leschaud';
        $link->invite  = $invite;

        $actual = $this->worker->userLabelsInGroupes($link);

        $expect = [
            2 => [
                0 => 'Cindy Leschaud',
                1 => 'label 1',
                2 => 'label 2',
                3 => 'label 3',
                4 => 'label 4',
                5 => 'label 5'
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
                1 => 'label 1',
                4 => 'label 4',
                5 => 'label 5'
            ],
            3 => [
                0 => 'Cindy Leschaud',
                1 => 'label 3'
            ]
        ];

        $this->worker->labels = [1,4,5];

        $actual2 = $this->worker->userLabelsInGroupes($link);
        $this->assertEquals($actual2, $expect2);
    }
}
