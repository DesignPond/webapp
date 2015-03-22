<?php

use App\Riiingme\Riiinglink\Entities\Riiinglink;

class RiiinglinkTransformerTest extends TestCase {

    protected $user;
    protected $transformer;
    protected $riiinglink;
    protected $label;
    protected $link;
    protected $link2;

    public function setUp()
    {
        parent::setUp();

        $this->user        = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->transformer = new App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer();
        $this->riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label       = \App::make('App\Riiingme\Label\Repo\LabelInterface');
        $this->link        = $this->riiinglink->find(1);
        $this->link2       = $this->riiinglink->find(5);
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
	public function testBasicExample()
	{
        $this->riiinglink->id = 1;

        $this->assertEquals(1, $this->riiinglink->id);
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
                13 => 'cyril.jpg'
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


    public function testLabel()
    {
        $label = $this->transformer->getLabelItem(31);

        $this->assertEquals('cyril.jpg', $label);
    }
}
