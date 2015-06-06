<?php

class ConvertTest extends TestCase {
    
    protected $converter;
    protected $riiinglink;

    public function setUp()
    {
        parent::setUp();

        $this->converter   = \App::make('App\Riiingme\Riiinglink\Worker\ConvertWorker');
        $this->riiinglink  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');

    }   
	/**
	 * A basic functional test example.
	 *
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

        $link = $this->riiinglink->find(1);

        $labels = $this->converter->loadUserLabels($link->first())->labelsInEffect();
echo '<pre>';
print_r($labels);
echo '</pre>';exit;
        $this->assertTrue(!empty($this->converter->labels));

    }
}
