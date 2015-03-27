<?php

class CreateRiiinglinkTest extends TestCase {

    protected $link;
    protected $command;
    protected $send;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->link = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');

        $user = $this->user->find(23);
        $data = ['email' => 'pruntrut@yahoo.fr', 'user_id' => 1, 'partage_host' => '', 'partage_invited' => ''];

        $this->send = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $invite = $this->send->create($data);

        $this->command = new App\Commands\CreateRiiinglink($user,$invite);
    }

    public function tearDown()
    {
        Mockery::close();

        $link = $this->link->findByHostAndInvited(23,1);
        $this->link->delete($link->id);
        $link = $this->link->findByHostAndInvited(1,23);
        $this->link->delete($link->id);
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCommandCreateRiiinglink()
	{

        $before = $this->getLastIdInDb();

        $before++;
        $before++;

        $this->command->handle();

        $after = $this->getLastIdInDb();

        $this->assertEquals($before, $after);

	}

    public function getLastIdInDb()
    {
        return \DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
    }

}
