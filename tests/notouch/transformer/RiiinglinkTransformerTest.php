<?php

use App\Riiingme\Riiinglink\Entities\Riiinglink;

class RiiinglinkTransformerTest extends TestCase {

    protected $user;
    protected $transformer;
    protected $riiinglink;
    protected $label;
    protected $link;
    protected $link2;
    protected $link3;
    protected $link4;
    protected $mock;
    protected $worker;

    public function setUp()
    {
        parent::setUp();

        $this->user        = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->transformer = new App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer();
        $this->riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label       = \App::make('App\Riiingme\Label\Repo\LabelInterface');
        $this->worker      = \App::make('App\Riiingme\Label\Worker\LabelWorker');

        $this->mock = Mockery::mock('App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer');
        $this->app->instance('App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer', $this->mock);

        $this->link        = $this->riiinglink->find(1);
        $this->link2       = $this->riiinglink->find(5);
        $this->link3       = $this->riiinglink->find(2);
        $this->link4       = $this->riiinglink->find(24);
    }

    public function tearDown()
    {
        Mockery::close();
    }
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testTransform()
	{
        $riiinglink = $this->transformer->transform($this->link2->first());

        $id      = $riiinglink['id'];
        $invited = $riiinglink['invited_id'];

        $this->assertEquals(5, $id);
        $this->assertEquals(1, $invited);

	}

    public function testGetName()
    {
        $this->transformer->host = $this->user->find(1);

        $this->assertEquals('Cindy Leschaud', $this->transformer->host->name);
    }

    public function testGetEmail()
    {
        $this->transformer->host = $this->user->find(1);

        $this->assertEquals('cindy.leschaud@gmail.com', $this->transformer->host->email);
    }

    public function testGetPhoto()
    {
        $this->transformer->host = $this->user->find(1);

        $this->assertEquals('cindy.jpg', $this->transformer->host->user_photo);
    }

    public function testGetPhotoNotExist()
    {
        $this->transformer->host = $this->user->find(4);

        $this->assertEquals('avatar.jpg', $this->transformer->host->user_photo);
    }

    public function testUserHasPeriodRange()
    {
        $actual = $this->transformer->userHasPeriodRange($this->user->find(2),2);

        $this->assertTrue($actual);
    }

    public function testUserHasPeriodRangeEmpty()
    {
        $actual = $this->transformer->userHasPeriodRange($this->user->find(2),5);

        $this->assertFalse($actual);
    }

    public function testGetHostLabels()
    {
        $expected = [
            1 => [
                12 => 'cyril.jpg'
            ],
            2 => [
                4 => 'label 1',
                5 => 'label 2',
                6 => 'label 3'
            ]
        ];

        $labels = $this->transformer->getHostLabels($this->link2->first());

        $this->assertEquals($expected, $labels);
    }


    public function testGetHostLabelsOther()
    {
        $expected = [];

        $labels = $this->transformer->getHostLabels($this->link4->first());

        $this->assertEquals($expected, $labels);
    }

    public function testGetInvitedLabels()
    {

        $expected = [
            1 => [
                12 => 'cindy.jpg'
            ],
            2 => [
                5 => 'Ruelle de l\'hôtel de ville 3',
                6 => '2520',
                7 => 'La Neuveville'
            ]
        ];

        //$labels = $this->transformer->getInvitedLabels($this->link2->first());

        //$this->assertEquals($expected, $labels);
    }

    public function testGetInvitedRiinglink()
    {
        $riiinglink = $this->transformer->getInvited($this->link2->first());

        $this->assertEquals(2, $riiinglink->id);

    }

    public function testLabel()
    {
        $label = $this->transformer->getLabelItem(31);

        $this->assertEquals('cyril.jpg', $label);
    }

    public function testLabelInvited()
    {
        $this->transformer->invited = $this->user->find(2);
        
        $labels = $this->transformer->getInvitedGroupLabels(2);

        $this->assertEquals(4, key($labels));
    }

    public function testLabelsIfGroupHasPeriodRange()
    {
        $coralie = $this->user->find(2);
        $date    = '2015-03-22 | 2015-05-31';

        $this->worker->updatePeriodRange($coralie, 4, $date);

       // $this->mock->shouldReceive('userHasPeriodRange')->with($coralie,2)->once()->andReturn(true);
       // $this->mock->shouldReceive('getInvitedGroupLabels')->with(2)->once()->andReturn([4 => [ 4 => 'rue du livre', 5 => '2345', 6 => 'Bâle' ]]);

        $data = [ 2 => [ 4 => 'La Voirde 19', 5 => '2735', 6 => 'Bévilard' ]];

        $labels = $this->transformer->getLabels($data,true);

        $this->assertTrue(in_array(4,array_keys($labels[2])));
    }

}
