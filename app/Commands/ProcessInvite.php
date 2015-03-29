<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class ProcessInvite extends Command implements SelfHandling {

    protected $riiinglink;
    protected $label;
    protected $user;
    protected $invite;
    protected $meta;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($invite)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label      = \App::make('App\Riiingme\Label\Worker\LabelWorker');
        $this->user       = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->meta       = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');

        $this->invite     = $invite;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        // infos to partage
        $partage_host    = (!empty($this->invite->partage_host) ? unserialize($this->invite->partage_host): []);
        $partage_invited = (!empty($this->invite->partage_invited) ? unserialize($this->invite->partage_invited): []);

        $hosted_link  = $this->getRiiinglink($this->invite->user_id , $this->invite->invited_id);
        $invited_link = $this->getRiiinglink($this->invite->invited_id , $this->invite->user_id);

        // sync labels

        if(!empty($partage_host)){
            $this->syncLabels($hosted_link->id, $this->invite->user_id, $partage_host);
        }

        if(!empty($partage_invited)){
            $this->syncLabels($invited_link->id, $this->invite->invited_id, $partage_invited);
        }

	}

    public function syncLabels($riiinglink_id,$user_id,$partage){

        $metas = $this->label->labelForUser($partage,$user_id);

        if(!empty($metas))
        {
            $this->meta->setMetasForRiiinglink($riiinglink_id,serialize($metas));
        }
    }

    public function getRiiinglink($host,$invited){

        $riiinglink =  $this->riiinglink->findByHostAndInvited($invited,$host);

        if($riiinglink)
        {
            return $riiinglink;
        }
    }
}
