<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class DestroyProfile extends Command implements SelfHandling, ShouldBeQueued {

    use InteractsWithQueue, SerializesModels;

    protected $user_id;
    protected $riiinglink;
    protected $user;
    protected $label;
    protected $activity;
    protected $metas;
    protected $id;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($user_id)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->user       = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->label      = \App::make('App\Riiingme\Label\Repo\LabelInterface');
        $this->activity   = \App::make('App\Riiingme\Activite\Repo\ActiviteInterface');
        $this->metas      = \App::make('App\Riiingme\Meta\Repo\MetaInterface');
        
        $this->id = $user_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $user = $this->user->find($this->id);

        $user->load('labels','invitations','activites','riiinglinks','riiinglinks_inverse');

        $labels       = $user->labels->lists('id');
        $invitations  = $user->invitations->lists('id');
        $activites    = $user->activites->lists('id');

        $allActivites = array_merge($invitations,$activites);

        $hosted  = $user->riiinglinks->lists('id');
        $inverse = $user->riiinglinks_inverse->lists('id');

        $riiinglinks = array_merge($hosted,$inverse);

        // Delete

        $this->activity->deleteAll($allActivites);
        $this->label->deleteAll($labels);
        $this->metas->deleteAll($riiinglinks);
        $this->riiinglink->deleteAll($riiinglinks);
        $this->user->delete($this->id);

        \Log::info('Everything Destroyed for user');
		
	}

    public function destroyMetas()
    {

    }

}
