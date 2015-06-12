<?php

class CreateRiiinglinkTest extends TestCase {

    protected $link;
    protected $meta;
    protected $link1;
    protected $link2;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->link = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->meta = \App::make('App\Riiingme\Meta\Repo\MetaInterface');

        $auth = $this->user->find(1);
        $this->be($auth);

        $user  = new App\Riiingme\User\Entities\User();

        $user->id = 100;
        $user->first_name  = 'Bob';
        $user->last_name   = 'Dupond';
        $user->email       = 'gaga@bob.com';
        $user->user_type    = 1;
        $user->save();

        list($link1 , $link2) = $this->link->create(['host_id' => 1, 'invited_id' => 100]);

        $metas  =  [
            2 => [  1 => 2,  6 => 3 ],
            3 => [  1 => 11,  6 => 16  ]
        ];

        $this->meta->create([ 'riiinglink_id' => $link1->id, 'labels' => serialize($metas) ]);
        $this->meta->create([ 'riiinglink_id' => $link2->id, 'labels' => serialize($metas) ]);

        $this->link1 = $link1;
        $this->link2 = $link2;

    }

    public function tearDown()
    {
        Mockery::close();

        // Delete meta and links
/*        $meta1 = $this->meta->findByRiiinglink($this->link2->id)->first();
        $meta2 = $this->meta->findByRiiinglink($this->link2->id)->first();

        $this->meta->delete($meta1->id);
        $this->meta->delete($meta2->id);

        $this->riiinglink->delete($this->link1->id);
        $this->riiinglink->delete($this->link2->id);*/


        //\DB::table('riiinglinks')->truncate();
        //$this->seed('RiiinglinksTableSeeder');
        //\DB::table('activites')->truncate();
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testDeleteRiiinglink()
	{
        $response = $this->call('GET', 'destroyLink/'.$this->link1->id);

        $this->assertRedirectedTo('user/1');

        // Delete user
        $auth = $this->user->find(100);
        $auth->delete(100);

	}

    public function getLastIdInDb()
    {
        return \DB::table('riiinglinks')->orderBy('id', 'desc')->first()->id;
    }

}
