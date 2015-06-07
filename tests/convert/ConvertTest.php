<?php

class ConvertTest extends TestCase {
    
    protected $converter;
    protected $riiinglink;
    protected $link;
    protected $meta;
    protected $user;
    protected $label;

    public function setUp()
    {
        parent::setUp();

        $this->converter   = \App::make('App\Riiingme\Riiinglink\Worker\ConvertWorker');
        $this->riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->meta   = \App::make('App\Riiingme\Meta\Repo\MetaInterface');
        $this->user   = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->label  = \App::make('App\Riiingme\Label\Repo\LabelInterface');

    }

    public function tearDown()
    {


       // \DB::table('invites')->truncate();
       // \DB::table('riiinglinks')->truncate();

    }

	/**
	 * @return void
	 */
	public function testLoadLabels()
	{

        $link = $this->riiinglink->find(1);

        $this->assertTrue(empty($this->converter->labels));

        $this->converter->loadUserLabels($link->first());

        $this->assertTrue(!empty($this->converter->labels));

	}

    public function testConvertMetasFormLabels()
    {

        $id = $this->createRiiinglinkAndCo();

        $link   = $this->riiinglink->find($id);
        $labels = $this->converter->loadUserLabels($link->first())->labelsInEffect();

echo '<pre>';
print_r($labels);
echo '</pre>';exit;

        $this->assertTrue(!empty($this->converter->labels));

        // Delete riiinglink
        $this->riiinglink->delete($id);
        // Delete meta
        $meta = $this->meta->findByRiiinglink($id)->first();
        $this->meta->delete($meta->id);
        // Delete lable
        $labels = $this->label->findByUser($user);
        $labels = $this->label->delete();
        $this->user->delete(3);
    }

    public function createRiiinglinkAndCo()
    {

        $user  = new App\Riiingme\User\Entities\User();

        $user->id = 3;
        $user->first_name  = 'Bob';
        $user->last_name   = 'Dupond';
        $user->email       = 'gaga@bob.com';

        list($link1 , $link2) = $this->link->create(['host_id' => 1, 'invited_id' => 3]);

        $metas  =  [
            2 => [  1 => 2,  6 => 3 ],
            3 => [  1 => 11,  6 => 16  ]
        ];

        $this->link = $this->meta->create([ 'riiinglink_id' => $link1->id, 'labels' => serialize($metas) ]);

        $this->label->create(['label' => 'gaga@bob.com', 'user_id' => 3, 'type_id' => 1, 'groupe_id' => 2]);
        $this->label->create(['label' => 'Villars', 'user_id' => 3, 'type_id' => 6, 'groupe_id' => 2]);
        $this->label->create(['label' => 'France', 'user_id' => 3, 'type_id' => 7, 'groupe_id' => 2]);
        $this->label->create(['label' => 'gaga@domain.ch', 'user_id' => 3, 'type_id' => 1, 'groupe_id' => 3]);
        $this->label->create(['label' => 'Bienne', 'user_id' => 3, 'type_id' => 6, 'groupe_id' => 3]);
        $this->label->create(['label' => 'Suisse', 'user_id' => 3, 'type_id' => 7, 'groupe_id' => 3]);

        return $link1->id;

    }
}
