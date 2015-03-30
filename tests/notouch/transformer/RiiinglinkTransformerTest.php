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

    public function setUp()
    {
        parent::setUp();

        $this->user        = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->transformer = new App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer();
        $this->riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label       = \App::make('App\Riiingme\Label\Repo\LabelInterface');
        $this->link        = $this->riiinglink->find(1);
        $this->link2       = $this->riiinglink->find(5);
        $this->link3       = $this->riiinglink->find(2);
        $this->link4       = $this->riiinglink->find(22);
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
        $name = $this->transformer->getName(1);

        $this->assertEquals('Cindy Leschaud', $name);
    }

    public function testGetEmail()
    {
        $email = $this->transformer->getEmail(1);

        $this->assertEquals('cindy.leschaud@gmail.com', $email);
    }

    public function testGetPhoto()
    {
        $photo = $this->transformer->getPhoto(1);

        $this->assertEquals('cindy.jpg', $photo);
    }

    public function testGetPhotoNotExist()
    {
        $photo = $this->transformer->getPhoto(4);

        $this->assertEquals('avatar.jpg', $photo);
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

        $labels = $this->transformer->getInvitedLabels($this->link2->first());

        $this->assertEquals($expected, $labels);
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

}
