<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class UpdateLabelUser extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($edit, $label)
	{
        $this->label      = $label;
        $this->interface  = \App::make('App\Riiingme\Label\Worker\LabelWorker');
        $this->edit       = $edit;
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

        $this->interface->createLabels($this->label, $user->id);
	}

}
