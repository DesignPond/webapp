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
        $expect  = '<input value="'.$data['text'].'" placeholder="032 555 55 55" type="text" name="edit['.$data['id'].']" class="form-control mask_tel">';

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
        $expect  = '<input value="'.$data['text'].'"  type="text" name="edit['.$data['id'].']" class="form-control ">';

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
        $expect  = '<input value="'.$data['text'].'"  type="text" name="edit['.$data['id'].']" class="form-control mask_email">';

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
        $expect  = '<input value="" placeholder="032 555 55 55" type="text" name="label['.$groupe.']['.$type.']" class="form-control mask_tel">';

        $this->assertEquals($expect, $actual);
    }
}
