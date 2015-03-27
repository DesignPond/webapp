<?php

class SendInviteTest extends TestCase {

    protected $command;
    protected $send;

    public function setUp()
    {
        parent::setUp();

        $this->send    = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $this->command = new App\Commands\SendInvite('pruntrut@yahoo.fr',1,'','');
    }

    public function tearDown()
    {
        Mockery::close();
        \DB::table('invites')->truncate();
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCommandSendInvite()
	{

        $this->command->handle();

        $invite = $this->getLastInDb();
        $id     = $invite->id;
        $email  = 'pruntrut@yahoo.fr';

        $calculate = $this->token($id,$email);

        $this->assertEquals($calculate, $invite->token);
        $this->assertEquals('', $invite->partage_host);

	}

    public function token($id,$email)
    {
        return  md5($id.$email);
    }

    public function getLastInDb()
    {
        return \DB::table('invites')->orderBy('id', 'desc')->first();
    }

}
