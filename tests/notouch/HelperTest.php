<?php

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

}
