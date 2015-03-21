<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class UpdateLabelUser extends Command implements SelfHandling {

    protected $edit;
    protected $label;
    protected $date;
    protected $interface;
    protected $helper;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($edit, $label, $date)
	{
        $this->label      = $label;
        $this->edit       = $edit;
        $this->date       = $date;
        $this->interface  = \App::make('App\Riiingme\Label\Worker\LabelWorker');
        $this->helper     = new \App\Riiingme\Helpers\Helper;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $user = \Auth::user();

        if(!empty($this->edit))
        {
            $this->interface->updateLabels($this->edit, $user->id);
        }

        foreach($this->label as $groupe => $labels)
        {
            $daterange = (isset($date[$groupe]) && !empty($date[$groupe]) ? $date[$groupe] : null);

            if($daterange && !empty($labels)){
                throw new  \App\Exceptions\UpdateFailException();
            }

            $this->interface->createLabels($labels, $user->id, $groupe, $daterange);

        }
	}

}
