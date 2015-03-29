<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class CreateRiiinglink extends Command implements SelfHandling {

    protected $riiinglink;
    protected $host;
    protected $invited;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($invited, $host)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');

		$this->invited = $invited;
        $this->host    = $host;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        // Create riiinglink
        return $this->riiinglink->create(['host_id' => $this->host, 'invited_id' => $this->invited]);

	}

}
