<?php

use League\FactoryMuffin\Facade as FactoryMuffin;

class ConfirmInviteTest extends TestCase {

    protected $link;
    protected $mock;
    protected $command;
    protected $invite;
    protected $token;
    protected $oneinvite;
    protected $secondinvite;

    public function setUp()
    {
        parent::setUp();

        //$this->mock = Mockery::mock('Illuminate\Contracts\Bus\Dispatcher');
       // $this->app->instance('Illuminate\Contracts\Bus\Dispatcher', $this->mock);

        $this->command = new App\Commands\ConfirmInvite( base64_encode('pruntrut@yahoo.fr'), '1234' );

        $this->link   = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->invite = \App::make('App\Riiingme\Invite\Repo\InviteInterface');

        $this->oneinvite = $this->invite->create([
            'email'           => 'pruntrut@yahoo.fr',
            'user_id'         => '1',
            'partage_host'    => serialize([2 => [5,6]]),
            'partage_invited' => serialize([2 => [5,6]])
        ]);

        $this->secondinvite  = $this->invite->setToken($this->oneinvite->id);

        $this->secondinvite = $this->invite->create([
            'email'           => 'coralie.95@hotmail.com',
            'user_id'         => '1',
            'partage_host'    => serialize([2 => [5,6]]),
            'partage_invited' => serialize([2 => [5,6]])
        ]);

        $this->secondinvite  = $this->invite->setToken($this->secondinvite->id);

    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    public function tearDown()
    {
        Mockery::close();

        \DB::table('invites')->truncate();
        \DB::table('riiinglinks')->truncate();

        //$this->seed('RiiinglinksTableSeeder');
    }

    public function testCreateRiiinglinkIfNotExist(){

        $host_id    = 3;
        $invited_id = 1;

        $link = $this->command->riiinglinkExist($host_id,$invited_id);

        $this->assertEquals(3, $link->host_id);
        $this->assertEquals(1, $link->invited_id);

    }

    public function testCreateRiiinglinkExist(){

        $host_id    = 3;
        $invited_id = 1;

        $this->link->create(['host_id' => $host_id, 'invited_id' => $invited_id]);

        $link = $this->command->riiinglinkExist($host_id,$invited_id);

        $this->assertEquals(3, $link->host_id);
        $this->assertEquals(1, $link->invited_id);

    }

	/**
	 *
	 * @return void
	 */
	public function testConfirmInvitation()
	{
        $id     = $this->oneinvite->id;
        $token  = $this->token($id,'pruntrut@yahoo.fr');

        $response = $this->call('GET', 'invite', [ 'ref'  => base64_encode('pruntrut@yahoo.fr'), 'token' => $token ] ,[], []);

        $this->assertRedirectedTo('/auth/register');

	}

    /**
     *
     * @return void
     */
    public function testConfirmInvitationFails()
    {
        $id     = $this->oneinvite->id;
        $token  = $this->token($id,'pruntrut@yahoo.fr');

        $response = $this->call('GET', 'invite', [ 'ref'  => '', 'token' => $token ] ,[], []);

        $this->assertRedirectedTo('/');

    }

    /**
     *
     * @return void
     */
    public function testConfirmInvitationLogin()
    {
        $id     = $this->secondinvite->id;
        $token  = $this->token($id,'coralie.95@hotmail.com');

        $response = $this->call('GET', 'invite', [ 'ref'  => base64_encode('coralie.95@hotmail.com'), 'token' => $token ] ,[], []);

        //$this->assertRedirectedTo('/user/link/1');
    }

    /**
     *
     * @return void
     */
    public function testConfirmInvitationFalseRef()
    {
        $id     = $this->secondinvite->id;
        $token  = $this->token($id,'coralie.95@hotmail.com');

        $response = $this->call('GET', 'invite', [ 'ref'  => base64_encode('coralie2@hotmail.com'), 'token' => $token ] ,[], []);

        $this->assertRedirectedTo('/');

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
