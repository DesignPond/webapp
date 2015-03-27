<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class CreateRiiinglink extends Command implements SelfHandling {

    protected $riiinglink;
    protected $label;
    protected $user;
    protected $invite;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($user, $invite)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label      = \App::make('App\Riiingme\Label\Worker\LabelWorker');

		$this->user   = $user;
        $this->invite = $invite;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        // Create riiinglink
        list($hosted_link,$invited_link) = $this->riiinglink->create(['host_id' => $this->invite->user_id, 'invited_id' => $this->user->id]);

        // infos to partage
        $partage_host    = (!empty($this->invite->partage_host) ? unserialize($this->invite->partage_host): []);
        $partage_invited = (!empty($this->invite->partage_invited) ? unserialize($this->invite->partage_invited): []);

        // Update invite
        $this->invite->invited_id = $this->user->id;
        $this->invite->save();

        // sync labels
        $this->syncLabels($hosted_link->id, $this->invite->user_id, $partage_host);
        $this->syncLabels($invited_link->id, $this->user->id, $partage_invited);

	}

    public function syncLabels($riiinglink_id,$user_id,$partage){

        $link  = $this->riiinglink->find($riiinglink_id)->first();
        $metas = $this->label->labelForUser($partage,$user_id);

        if(!empty($metas))
        {
            $link->labels()->sync($metas);
        }

    }
}
