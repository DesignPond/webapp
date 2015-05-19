<?php

use Faker\Factory as Faker;

class HelperTest extends TestCase {

    protected $helper;

    public function setUp()
    {
        parent::setUp();

        $this->helper = new \App\Riiingme\Helpers\Helper;
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testIsEmpty()
	{
        $array = [
            3 => [],
            4 => [],
            5 => [],
            6 => []
        ];

        $actual  = $this->helper->isNotEmpty($array);
        $expect  = false;

        $this->assertEquals($expect, $actual);
	}

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIsNotEmpty()
    {
        $array = [
            3 => [1 => 'item'],
            4 => [],
            5 => [],
            6 => []
        ];

        $actual  = $this->helper->isNotEmpty($array);
        $expect  = true;

        $this->assertEquals($expect, $actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testConvertDateRange()
    {
        $date = '2015-03-22 | 2015-05-31';

        $actual  = $this->helper->convertDateRange($date);
        $expect  = ['start_at' => '2015-03-22', 'end_at' => '2015-05-31'];

        $this->assertEquals($expect, $actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testPrepareInputTel()
    {
        $type    = 9;
        $groupe  = 2;
        $data    = ['id' => 1,'text' => 'label'];

        $actual  = $this->helper->generateInput($type, $groupe, true, $data);
        $expect  = '<input value="'.$data['text'].'" type="text" name="edit['.$data['id'].']" class="form-control mask_tel" placeholder="032 555 55 55">';

        $this->assertEquals($expect, $actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testPrepareInput()
    {
        $type    = 2;
        $groupe  = 2;
        $data    = ['id' => 1,'text' => 'label'];

        $actual  = $this->helper->generateInput($type, $groupe, true, $data);
        $expect  = '<input value="'.$data['text'].'" type="text" name="edit['.$data['id'].']" class="form-control " placeholder="">';

        $this->assertEquals($expect, $actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testPrepareInputEmail()
    {
        $type    = 1;
        $groupe  = 2;
        $data    = ['id' => 1,'text' => 'label'];

        $actual  = $this->helper->generateInput($type, $groupe, true, $data);
        $expect  = '<input value="'.$data['text'].'" type="text" name="edit['.$data['id'].']" class="form-control mask_email" placeholder="nom@domaine.ch">';

        $this->assertEquals($expect, $actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testPrepareInputTelDontExist()
    {
        $type    = 9;
        $groupe  = 2;

        $actual  = $this->helper->generateInput($type, $groupe, false);
        $expect  = '<input value="" type="text" name="label['.$groupe.']['.$type.']" class="form-control mask_tel" placeholder="032 555 55 55">';

        $this->assertEquals($expect, $actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetUsedMetas()
    {
        $id     = 1;
        $groupe = 2;
        $metas  = [
            2 => [1,2,3]
        ];

        $actual = $this->helper->getUsedMetas($id, $metas,$groupe);

        $this->assertTrue($actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetNotUsedMetas()
    {
        $id     = 1;
        $groupe = 2;
        $metas  = [
            2 => [2,3]
        ];

        $actual = $this->helper->getUsedMetas($id, $metas,$groupe);

        $this->assertFalse($actual);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSearchArray()
    {
        $key   = 'type_id';
        $value = 12;
        $array = [
            [
                'label'     => 'coralie.jpg',
                'type_id'   => 12
            ],
            [
                'label'     => 'cindy.jpg',
                'type_id'   => 11
            ],
            [
                'label'     => 'avatar.jpg',
                'type_id'   => 10
            ]
        ];

        $actual = $this->helper->getKeyValue($array,$key,$value);
        $expect = 'coralie.jpg';

        $this->assertEquals($expect,$actual);
    }

    public function testMetaCompare(){

        $new = [
            3 => [
                6 => 16,
                3 => 13,
                7 => 17
            ]
        ];

        $metas = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                6 => 16,
            ]
        ];

        //$actual = $this->helper->array_merge_recursive_new($metas,$new); // $inputs, $user_id, $groupe, $date = null
        $actual = $this->helper->addMetas($metas,$new);

        $expected = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                3 => 13,
                6 => 16,
                7 => 17
            ]
        ];

        $this->assertEquals($expected, $actual);
    }


    public function testMetaCompareSecond(){

        $metas = [
            3 => [
                6 => 16,
                3 => 13,
                7 => 17
            ]
        ];

        $new = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                6 => 16,
            ]
        ];

        //$actual = $this->helper->array_merge_recursive_new($metas,$new); // $inputs, $user_id, $groupe, $date = null
        $actual = $this->helper->addMetas($metas,$new);

        $expected = [
            2 => [
                1 => 2,
                4 => 3,
                5 => 4
            ],
            3 => [
                1 => 11,
                3 => 13,
                6 => 16,
                7 => 17
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testConvertForChanges()
    {
        $labels = [
            2 => [
                4,5,10
            ],
            3 => [
                6,11
            ]
        ];

        $actual = $this->helper->convertForUserType($labels);

        $expected = [
            6 => [
                4, 5, 6, 11
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testConvertAutoComplete()
    {
        $faker = Faker::create();

        $users = [];

        $noms = [
            'first_name'   => ['','Cindy','Celine','Cyril','Coralie'],
            'last_name'    => ['','Leschaud','Leschaud','Leschaud','Leschaud'],
            'email'        => ['','cindy@domaine.ch','celine@domaine.ch','cyril@domaine.ch','coralie@domaine.ch'],
            'name_search'  => ['','yes','no','yes','no'],
            'email_search' => ['','yes','no','yes','no'],
            'user_type'    => ['',1,2,1,2],
        ];

        for($i = 1; $i < 5;$i++)
        {
            $user = new App\Riiingme\User\Entities\User;

            $user->id           = $i;
            $user->first_name   = $noms['first_name'][$i];
            $user->last_name    = $noms['last_name'][$i];
            $user->email        = $noms['email'][$i];
            $user->name_search  = $noms['name_search'][$i];
            $user->email_search = $noms['email_search'][$i];
            $user->user_type    = $noms['user_type'][$i];

            $users[$i] = $user;
        }

        $collection = new Illuminate\Database\Eloquent\Collection($users);


        $actual = $this->helper->convertAutocomplete($collection);

        $expect = [
            ['label' => 'Cindy Leschaud', 'desc' => 'cindy@domaine.ch', 'value' => 'cindy@domaine.ch', 'id' => 1, 'user_type' => 1],
            ['label' => 'celine@domaine.ch', 'desc' => 'celine@domaine.ch', 'value' => 'celine@domaine.ch', 'id' => 2, 'user_type' => 2],
            ['label' => 'Cyril Leschaud', 'desc' => 'cyril@domaine.ch', 'value' => 'cyril@domaine.ch', 'id' => 3, 'user_type' => 1],
            ['label' => 'coralie@domaine.ch', 'desc' => 'coralie@domaine.ch', 'value' => 'coralie@domaine.ch', 'id' => 4, 'user_type' => 2]
        ];

        $this->assertEquals($expect,$actual);
    }

}
