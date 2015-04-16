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
	public function __construct($invite_id)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label      = \App::make('App\Riiingme\Label\Worker\LabelWorker');
        $this->user       = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->worker     = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');

        $this->invite     = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $this->invite_id  = $invite_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $invite = $this->invite->find($this->invite_id);

        // infos to partage
        $partage_host    = (!empty($invite->partage_host) ? unserialize($invite->partage_host): []);
        $partage_invited = (!empty($invite->partage_invited) ? unserialize($invite->partage_invited): []);

        $hosted_link  = $this->getRiiinglink($invite->user_id , $invite->invited_id);
        $invited_link = $this->getRiiinglink($invite->invited_id , $invite->user_id);

        // sync labels
        if(!empty($partage_host)){
            $this->syncLabels($hosted_link, $partage_host);
        }

        if(!empty($partage_invited)){
            $this->syncLabels($invited_link, $partage_invited);
        }
	}

    public function syncLabels($riiinglink,$partage){

        $metas = $this->label->labelForUser($partage,$riiinglink->host_id);

        if(!empty($metas))
        {
            $this->worker->setMetasForRiiinglink($riiinglink->host_id,$riiinglink->id,$metas);
        }
    }

    public function getRiiinglink($host,$invited){

        $riiinglink =  $this->riiinglink->findByHostAndInvited($host,$invited);

        if($riiinglink)
        {
            return $riiinglink;
        }

        return false;
    }
}
