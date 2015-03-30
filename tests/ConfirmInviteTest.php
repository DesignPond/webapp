<?php

use League\FactoryMuffin\Facade as FactoryMuffin;

class ConfirmInviteTest extends TestCase {

    protected $link;
    protected $command;
    protected $invite;
    protected $token;
    protected $oneinvite;
    protected $secondinvite;

    public function setUp()
    {
        parent::setUp();

        //Invite fixture
/*        FactoryMuffin::define('Invite', array(
            'email'        => 'pruntrut@yahoo.fr',
            'user_id'      => '1',
            'partage_host' => serialize([2 => [5,6]]),
            'partage_host' => serialize([2 => [5,6]])
        ));*/

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

        $this->seed('RiiinglinksTableSeeder');
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

        //$this->assertRedirectedTo('/user');

    }

    /**
     *
     * @return void
     */
    public function testConfirmInvitationFalseRef()
    {
        $id     = $this->secondinvite->id;
        $token  = $this->token($id,'coralie.95@hotmail.com');

        $response = $this->call('GET', 'invite', [ 'ref'  => base64_encode('coralie@hotmail.com'), 'token' => $token ] ,[], []);

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
