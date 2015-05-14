<?php

class ProcessInviteTest extends TestCase {

    protected $link;
    protected $meta;
    protected $command;
    protected $invite;
    protected $user;
    protected $link1;
    protected $link2;
    protected $invitation;
    protected $helper;

    public function setUp()
    {
        parent::setUp();

        $this->meta    = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');
        $this->link    = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');

        list($this->link1 , $this->link2) = $this->link->create(['host_id' => 1, 'invited_id' => 23]);

        $toconvert = [
            2 => [1,4,5,6]
        ];

        $data = ['email' => 'pruntrut@yahoo.fr', 'user_id' => 1,'invited_id' => 23, 'partage_host' => serialize([2 => [1]]), 'partage_invited' => serialize($toconvert)];

        $this->invite     = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $this->invitation = $this->invite->create($data);

        $this->helper     = new \App\Riiingme\Helpers\Helper;
        $this->command    = new App\Commands\ProcessInvite($this->invitation->id);
    }

    public function tearDown()
    {
        Mockery::close();
        \DB::table('invites')->truncate();
        \DB::table('riiinglinks')->truncate();
        $this->seed('RiiinglinksTableSeeder');
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testProcessInvite()
	{

        $before = $this->getLastIdInDb();

        $before++;
        $before++;

       // $this->command->handle();

        //$after = $this->getLastIdInDb();

        //$this->assertEquals($before, $after);

	}

    public function testProcessLabels(){

        $partage = [
            2 => [
                0 => 4,
                1 => 5,
                2 => 6
            ],
            3 => [
                0 => 3,
                1 => 4
            ]
        ];

        $expected = [
            2 => [
                4 => 3,
                5 => 4,
                6 => 5
            ],
            3 => [
                3 => 13,
                4 => 14
            ]
        ];

        $labels = $this->command->convertMetasToLabels($this->link1,$partage);

        $this->assertEquals($expected,$labels->metas);
    }

    public function testSyncLabels(){

        $partage = [
            2 => [
                0 => 4,
                1 => 5,
                2 => 6
            ],
            3 => [
                0 => 3,
                1 => 4
            ]
        ];

        $expected = [
            2 => [
                4 => 3,
                5 => 4,
                6 => 5
            ],
            3 => [
                3 => 13,
                4 => 14
            ]
        ];

        $converted = $this->command->convertMetasToLabels($this->link1,$partage);

        $converted->syncLabels($this->link1);
        $riinglink = $this->link->find($this->link1->id)->first();

        $this->assertEquals($expected,unserialize($riinglink->usermetas->labels));
    }

    public function testSyncAddLabels(){

        $partage = [
            2 => [
                0 => 4,
                1 => 5,
                2 => 6
            ],
            3 => [
                0 => 3,
                1 => 4,
                2 => 5
            ]
        ];

        $expected = [
            2 => [
                4 => 3,
                5 => 4,
                6 => 5
            ],
            3 => [
                3 => 13,
                4 => 14,
                5 => 15
            ]
        ];


        $converted = $this->command->convertMetasToLabels($this->link1,$partage);

        $converted->syncLabels($this->link1);
        $riinglink = $this->link->find($this->link1->id)->first();

        $this->assertEquals($expected,unserialize($riinglink->usermetas->labels));
    }

    public function testGetRiiinglink()
    {
        $riinglinkId = $this->command->getRiiinglink(1,23);

        $this->assertEquals(22, $riinglinkId->id);
    }

    public function testInvitedInvitation()
    {

        $user_id = $this->invitation->user_id;

        $this->assertEquals(1, $user_id);
    }
    
    public function getLastIdInDb()
    {
        return \DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
    }

}
