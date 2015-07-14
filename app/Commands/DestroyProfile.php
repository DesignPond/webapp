<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class DestroyProfile extends Command implements SelfHandling {

    protected $user_id;
    protected $riiinglink;
    protected $user;
    protected $label;
    protected $activity;
    protected $metas;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($user_id)
	{
        $this->riiinglink = \App::make('App\Riiingme\Riiinglink\Worker\RiiinglinkWorker');
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

        $metas = $this->metas->findAll($riiinglinks);

        // Delete
/*        $this->activity->deleteAll($allActivites);
        $this->label->deleteAll($labels);
        $this->metas->deleteAll($riiinglinks);
        $this->riiinglink->deleteAll($riiinglinks);*/

        echo '<pre>';
        print_r($allActivites);
        echo '</pre>';exit;
		
	}

    public function destroyMetas()
    {

    }

}
