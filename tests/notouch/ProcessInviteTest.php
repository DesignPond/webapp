<?php

class ProcessInviteTest extends TestCase {

    protected $link;
    protected $meta;
    protected $command;
    protected $invite;
    protected $user;
    protected $link1;
    protected $link2;

    public function setUp()
    {
        parent::setUp();

        $this->meta    = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');
        $this->link    = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        list($this->link1 , $this->link2) = $this->link->create(['host_id' => 1, 'invited_id' => 23]);

        $data = ['email' => 'pruntrut@yahoo.fr', 'user_id' => 1,'invited_id' => 23, 'partage_host' => serialize([2 => [1]]), 'partage_invited' => serialize([2 => [1]])];

        $this->invite  = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $invitation    = $this->invite->create($data);

        $this->command = new App\Commands\ProcessInvite($invitation);
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

/*
        $before = $this->getLastIdInDb();

        $before++;
        $before++;

        $this->command->handle();

        $after = $this->getLastIdInDb();

        $this->assertEquals($before, $after);
    */

	}

    public function testGetRiiinglink()
    {

        $before      = $this->getLastIdInDb();
        $riinglinkId = $this->command->getRiiinglink(1,23);

        $this->assertEquals($before, $riinglinkId->id);
    }


    public function testSyncLabels()
    {

        $this->meta->setMetasForRiiinglink($this->link1->id,serialize([2 => [1]]));

        $riinglink = $this->link->find($this->link1->id);
        $riinglink = $riinglink->first();

        $this->command->syncLabels($this->link1,23,[2 => [1]]);
        
        $this->assertEquals(serialize([2 => [1]]),$riinglink->usermetas->labels);
    }
    
    public function getLastIdInDb()
    {
        return \DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
    }

}
