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

    public function testFlattenArray()
    {
        $array = [
            3 => [
                'Adresse privé' => [ 'coralie.leschaud@orange.ch', 'La Voirde 19'],
                'Adresse professionnelle' => [ 'Salt', 'ARC']
            ],
            4 => [
                'Adresse privé' => [ 'libelulle867@bluewin.ch', '1950'],
                'Adresse professionnelle' => [ 'Suisse', 'ARC']
            ],
            5 => [
                'Adresse privé' => [ 'samanta.marks@gmail.com'],
                'Adresse professionnelle' => [ '02790524922']
            ]
        ];

        $actual  = $this->helper->array_flatten($array);
        $expect  = [
            'Adresse privé' => [ 'coralie.leschaud@orange.ch', 'La Voirde 19'],
            'Adresse professionnelle' => [ 'Salt', 'ARC'],
            'Adresse privé' => [ 'libelulle867@bluewin.ch', '1950'],
            'Adresse professionnelle' => [ 'Suisse', 'ARC'],
            'Adresse privé' => [ 'samanta.marks@gmail.com'],
            'Adresse professionnelle' => [ '02790524922']
        ];

/*        echo '<pre>';
        print_r($actual);
        echo '</pre>';exit;*/
        //$this->assertEquals($expect, $actual);
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
        $date = '22/03/2015 | 31/05/2015';

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

    public function testAddTempLabel(){

        $labels = [
            2 => [1 => 2, 4 => 3, 5 => 4],
            3 => [1 => 11, 6 => 16,]
        ];

        $labels = serialize($labels);
        $actual = $this->helper->addTempLabelsForChanges($labels);

        $expected = [
            2 => [1 => 2, 4 => 3, 5 => 4],
            3 => [1 => 11, 6 => 16,],
            4 => [1 => 2, 4 => 3, 5 => 4],
            5 => [1 => 11, 6 => 16,]
        ];

        $expected = serialize($expected);

        $this->assertEquals($expected, $actual);
    }


    public function testAddTempLabelOneGroupe(){

        $labels = [
            3 => [1 => 11, 6 => 16,]
        ];

        $labels = serialize($labels);
        $actual = $this->helper->addTempLabelsForChanges($labels);

        $expected = [
            3 => [1 => 11, 6 => 16,],
            5 => [1 => 11, 6 => 16,]
        ];

        $expected = serialize($expected);

        $this->assertEquals($expected, $actual);
    }

    public function testAddTempLabelWithCompany(){

        $labels = [
            6 => [1 => 2, 4 => 3, 5 => 4]
        ];

        $labels = serialize($labels);
        $actual = $this->helper->addTempLabelsForChanges($labels);

        $expected = [
            6 => [1 => 2, 4 => 3, 5 => 4]
        ];

        $expected = serialize($expected);

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


    public function testOrderTypesByRang()
    {
        $labels = [
            4  => 'label4',
            5  => 'label5',
            11 => 'label11',
            13 => 'label13'
        ];

        $sort = [
            2,
            4,
            5,
            6,
            7,
            13,
            11,
        ];

        $actual = $this->helper->sortArrayByArray($labels,$sort);

        $expected = [
            4  => 'label4',
            5  => 'label5',
            13 => 'label13',
            11 => 'label11'
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testConvertAutoComplete()
    {
        $faker = Faker::create();

        $users = [];

        $noms = [
            [
                'first_name'   => ['','Cindy','Céline','Cyril','Coralie'],
                'last_name'    => ['','Leschaud','Leschaud','Leschaud','Leschaud'],
                'company'      => ['','Entreprise Leschaud','Entreprise Leschaud','Entreprise Leschaud','Entreprise Leschaud'],
                'email'        => ['','cindy@domaine.ch','celine@domaine.ch','cyril@domaine.ch','coralie@domaine.ch'],
                'name_search'  => ['',1,1,1,1],
                'email_search' => ['',1,1,1,1],
                'user_type'    => ['',1,2,1,2]
            ],
            [
                'first_name'   => ['','Cindy','Celine','Cyril','Coralie'],
                'last_name'    => ['','Leschaud','Leschaud','Leschaud','Leschaud'],
                'company'      => ['','Entreprise Leschaud','Entreprise Leschaud','Entreprise Leschaud','Entreprise Leschaud'],
                'email'        => ['','cindy@domaine.ch','celine@domaine.ch','cyril@domaine.ch','coralie@domaine.ch'],
                'name_search'  => ['',0,0,0,0],
                'email_search' => ['',1,1,1,1],
                'user_type'    => ['',1,2,1,2]
            ]
        ];

        $actual = [];

        foreach($noms as $nom)
        {
            for($i = 1; $i < 5;$i++)
            {
                $user = new App\Riiingme\User\Entities\User;

                $user->id           = $i;
                $user->first_name   = $nom['first_name'][$i];
                $user->last_name    = $nom['last_name'][$i];
                $user->company      = $nom['company'][$i];
                $user->email        = $nom['email'][$i];
                $user->name_search  = $nom['name_search'][$i];
                $user->email_search = $nom['email_search'][$i];
                $user->user_type    = $nom['user_type'][$i];

                $users[$i] = $user;
            }

            $collection = new Illuminate\Database\Eloquent\Collection($users);
            $actual[]   = $this->helper->convertAutocomplete($collection);
        }

        $expect = [
            [
                ['label' => 'Cindy Leschaud', 'desc' => 'cindy@domaine.ch', 'value' => 'cindy@domaine.ch', 'id' => 1, 'user_type' => 1],
                ['label' => 'Entreprise Leschaud', 'desc' => 'celine@domaine.ch', 'value' => 'celine@domaine.ch', 'id' => 2, 'user_type' => 2],
                ['label' => 'Cyril Leschaud', 'desc' => 'cyril@domaine.ch', 'value' => 'cyril@domaine.ch', 'id' => 3, 'user_type' => 1],
                ['label' => 'Entreprise Leschaud', 'desc' => 'coralie@domaine.ch', 'value' => 'coralie@domaine.ch', 'id' => 4, 'user_type' => 2]
            ],
            [
                ['label' => 'cindy@domaine.ch',   'desc' => 'cindy@domaine.ch',   'value' => 'cindy@domaine.ch',   'id' => 1, 'user_type' => 1],
                ['label' => 'celine@domaine.ch',  'desc' => 'celine@domaine.ch',  'value' => 'celine@domaine.ch',  'id' => 2, 'user_type' => 2],
                ['label' => 'cyril@domaine.ch',   'desc' => 'cyril@domaine.ch',   'value' => 'cyril@domaine.ch',   'id' => 3, 'user_type' => 1],
                ['label' => 'coralie@domaine.ch', 'desc' => 'coralie@domaine.ch', 'value' => 'coralie@domaine.ch', 'id' => 4, 'user_type' => 2]
            ]
        ];


        $this->assertEquals($expect[0],$actual[0]);
        $this->assertEquals($expect[1],$actual[1]);
    }



}
