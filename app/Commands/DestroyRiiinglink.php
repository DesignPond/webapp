<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class DestroyRiiinglink extends Command implements SelfHandling {

    protected $riiinglink_id;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($riiinglink_id)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->meta       = \App::make('App\Riiingme\Meta\Repo\MetaInterface');

        $this->id = $riiinglink_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//
	}

}
