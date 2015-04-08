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

        $data = ['email' => 'pruntrut@yahoo.fr', 'user_id' => 1,'invited_id' => 23, 'partage_host' => serialize([2 => [1]]), 'partage_invited' => serialize([2 => [1]])];

        $this->invite     = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $this->invitation = $this->invite->create($data);

        $this->helper     = new \App\Riiingme\Helpers\Helper;

        $this->command = new App\Commands\ProcessInvite($this->invitation);
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

        $this->command->handle();

        $after = $this->getLastIdInDb();

        //$this->assertEquals($before, $after);


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

    public function testSyncLabels()
    {
        list($link1 , $link2) = $this->link->create(['host_id' => 1, 'invited_id' => 24]);

        $this->command->syncLabels($link1->id, $link1->host_id, [2 => [1]]);

        $riinglink = $this->link->find($link1->id)->first();
        $expected  = [2 => [1 => 2]];

        $this->assertEquals($expected,unserialize($riinglink->usermetas->labels));
    }
    
    public function getLastIdInDb()
    {
        return \DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
    }

}
