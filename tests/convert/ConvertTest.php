<?php

class ConvertTest extends TestCase {
    
    protected $converter;
    protected $riiinglink;
    protected $link;
    protected $link2;
    protected $meta;
    protected $user;
    protected $label;
    protected $worker;

    public function setUp()
    {
        parent::setUp();

        $this->converter   = \App::make('App\Riiingme\Riiinglink\Worker\ConvertWorker');
        $this->riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->meta   = \App::make('App\Riiingme\Meta\Repo\MetaInterface');
        $this->user   = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->label  = \App::make('App\Riiingme\Label\Repo\LabelInterface');
        $this->worker = \App::make('App\Riiingme\Label\Worker\LabelWorker');

        list($link1 , $link2) = $this->createRiiinglinkAndCo();

        $this->link  = $link1;
        $this->link2 = $link2;
    }

    public function tearDown()
    {

        // Delete user
        $model = new App\Riiingme\User\Entities\User();
        $user = $model->find(3);

        if($user){
            $this->worker->updatePeriodRange($user, 4, null);
            $user->delete(3);
        }

        // Delete meta
        $meta = $this->meta->findByRiiinglink($this->link2->id)->first();
        $this->meta->delete($meta->id);
        // Delete labels
        \App\Riiingme\Label\Entities\Label::where('user_id','=',3)->delete();
        \DB::table('user_groups')->truncate();
        // \DB::table('riiinglinks')->truncate();
        //\DB::table('metas')->truncate();
        // Delete riiinglink
        $this->riiinglink->delete($this->link->id);
        $this->riiinglink->delete($this->link2->id);
    }

	/**
	 * @return void
	 */
	public function testLoadLabels()
	{

        $this->assertTrue(empty($this->converter->labels));

        $this->converter->loadUserLabels($this->link2);

        $this->assertTrue(!empty($this->converter->labels));

	}

    public function testRiiinkglink()
    {
        $this->converter->loadUserLabels($this->link);

        $this->assertEquals( $this->link2->id, $this->converter->link->id);
    }

    public function testPrepareLabels()
    {

        \DB::table('user_groups')->truncate();

        $this->converter->loadUserLabels($this->link)->prepareLabels();

        $actual = [
            2 => [
                1 => 'gaga@bob.com',
                6 => 'Villars',
                7 => 'France'
            ],
            3 => [
                1 => 'gaga@domain.ch',
                6 => 'Bienne',
                7 => 'Suisse'
            ],
            4 => [
                1 => 'bob@new.ch',
                6 => 'Bévilard',
                7 => 'Canada'
            ],
            5 => [
                1 => 'gaga@new.ch',
                6 => 'Nidau',
                7 => 'USA'
            ]
        ];

        $this->assertEquals( $this->converter->labels ,$actual);

    }

    public function testConvertMetasFormLabels()
    {
        $this->converter->loadUserLabels($this->link)->metasInEffect();

        $metas  = [
            2 => [ 1 , 6 ],
            3 => [ 1 , 6 ],
            4 => [ 1 , 6 ],
            5 => [ 1 , 6 ]
        ];

        $this->assertEquals($metas,$this->converter->metas);

    }

    public function testLabelsToShow()
    {
        $this->converter->metas = [3 => [1,7]];

        $this->converter->labels = [
            3 => [
                1 => 'gaga@domain.ch',
                6 => 'Bienne',
                7 => 'Suisse'
            ]
        ];

        $expected = [3 => [ 1 => 'gaga@domain.ch',7 => 'Suisse']];

        $this->converter->labelsToShow();

        $this->assertEquals( $this->converter->labels, $expected );

    }

    public function testLabelsToShowWithPeriod()
    {
        \DB::table('user_groups')->truncate();

        $user    = $this->user->find(3);
        $carbon  = \Carbon\Carbon::now();
        $start   = $carbon->toDateString();
        $end     = $carbon->addMonth();
        $date    = $start.' | '.$end;
        $this->worker->updatePeriodRange($user, 5, $date);

        $this->converter->loadUserLabels($this->link);
        $this->converter->metas = [3 => [1 => 1, 7 => 6]];

        $this->converter->prepareLabels()->metasInEffect();
        $this->converter->convertPeriodRange();
        $this->converter->labelsToShow();

        $expected = [
            5 => [ 1 => 'gaga@new.ch', 7 => 'USA']
        ];

        $this->assertEquals( $this->converter->labels, $expected );

    }

    public function testLabelsWithName()
    {
        \DB::table('user_groups')->truncate();

        $this->converter->loadUserLabels($this->link);
        $this->converter->metas = [3 => [1,7]];

        $this->converter->labels = [
            3 => [
                1 => 'gaga@domain.ch',
                6 => 'Bienne',
                7 => 'Suisse'
            ]
        ];

        $expected = [
            3 => [
                0 => 'Bob Dupond',
                1 => 'gaga@domain.ch',
                7 => 'Suisse'
            ]
        ];

        $this->converter->labelsToShow()->addName();

        $this->assertEquals( $this->converter->labels, $expected );

    }

    public function testPeriodRangeInEffect()
    {
        $start = \Carbon\Carbon::now()->toDateString();
        $end   = \Carbon\Carbon::now()->addWeeks(2)->toDateString();

        $users_groups1  = new App\Riiingme\User\Entities\User_group();
        $users_groups2  = new App\Riiingme\User\Entities\User_group();

        $users_groups1->groupe_id = 4;
        $users_groups1->start_at  = $start;
        $users_groups1->end_at    = $end;
        $users_groups2->groupe_id = 5;
        $users_groups2->start_at  = '2014-11-31';
        $users_groups2->end_at    = '2014-12-31';

        $collection = new Illuminate\Database\Eloquent\Collection([$users_groups1,$users_groups2]);

        $data = [
            2 => [ 3 => 'label', 4 => 'label'],
            3 => [ 5 => 'label', 6 => 'label'],
            4 => [ 7 => 'label', 8 => 'label'],
            5 => [ 9 => 'label', 1 => 'label']
        ];

        $expect =  [
            3 => [ 5 => 'label', 6 => 'label'],
            4 => [ 7 => 'label', 8 => 'label'],
        ];

        $actual = $this->converter->periodIsInEffect($collection, $data);

        $this->assertEquals($expect,$actual);
    }
    
    public function createRiiinglinkAndCo()
    {

        $user  = new App\Riiingme\User\Entities\User();

        $user->id = 3;
        $user->first_name  = 'Bob';
        $user->last_name   = 'Dupond';
        $user->email       = 'gaga@bob.com';
        $user->user_type    = 1;
        $user->save();

        list($link1 , $link2) = $this->riiinglink->create(['host_id' => 1, 'invited_id' => 3]);

        $metas  =  [
            2 => [  1 => 2,  6 => 3 ],
            3 => [  1 => 11,  6 => 16  ]
        ];

        $this->meta->create([ 'riiinglink_id' => $link2->id, 'labels' => serialize($metas) ]);

        $this->label->create(['label' => 'gaga@bob.com', 'user_id' => 3, 'type_id' => 1, 'groupe_id' => 2]);
        $this->label->create(['label' => 'Villars', 'user_id' => 3, 'type_id' => 6, 'groupe_id' => 2]);
        $this->label->create(['label' => 'France', 'user_id' => 3, 'type_id' => 7, 'groupe_id' => 2]);

        $this->label->create(['label' => 'gaga@domain.ch', 'user_id' => 3, 'type_id' => 1, 'groupe_id' => 3]);
        $this->label->create(['label' => 'Bienne', 'user_id' => 3, 'type_id' => 6, 'groupe_id' => 3]);
        $this->label->create(['label' => 'Suisse', 'user_id' => 3, 'type_id' => 7, 'groupe_id' => 3]);

        $this->label->create(['label' => 'bob@new.ch', 'user_id' => 3, 'type_id' => 1, 'groupe_id' => 4]);
        $this->label->create(['label' => 'Bévilard', 'user_id' => 3, 'type_id' => 6, 'groupe_id' => 4]);
        $this->label->create(['label' => 'Canada', 'user_id' => 3, 'type_id' => 7, 'groupe_id' => 4]);

        $this->label->create(['label' => 'gaga@new.ch', 'user_id' => 3, 'type_id' => 1, 'groupe_id' => 5]);
        $this->label->create(['label' => 'Nidau', 'user_id' => 3, 'type_id' => 6, 'groupe_id' => 5]);
        $this->label->create(['label' => 'USA', 'user_id' => 3, 'type_id' => 7, 'groupe_id' => 5]);

        return [$link1,$link2];

    }
}
