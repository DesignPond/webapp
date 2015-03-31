<?php

class PagesTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $interface = \App::make('App\Riiingme\User\Repo\UserInterface');
        $user      = $interface->find(1);
        $this->be($user);
    }

	/**
	 *
	 * @return void
	 */
	public function testBackendIndex()
	{
		$response = $this->call('GET', 'user');
		$this->assertEquals(200, $response->getStatusCode());
	}

    /**
     *
     * @return void
     */
    public function testBackendEdit()
    {
        $response = $this->call('GET', 'user/1/edit');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     *
     * @return void
     */
    public function testBackendPartage()
    {
        $response = $this->call('GET', 'user/partage');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     *
     * @return void
     */
    public function testBackendContacts()
    {
        $response = $this->call('GET', 'user/1');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     *
     * @return void
     */
    public function testBackendLink()
    {
        $response = $this->call('GET', 'user/link/1');
        $this->assertEquals(200, $response->getStatusCode());
    }

}
