<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Riiingme\User\Entities\User;
use App\Riiingme\Label\Entities\Label;
use App\Riiingme\Meta\Entities\Meta;
use App\Riiingme\Type\Entities\Type;
use App\Riiingme\Groupe\Entities\Groupe;
use App\Riiingme\Riiinglink\Entities\Riiinglink;
use App\Riiingme\Invite\Entities\Invite;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{

        $this->registerUserService();
        $this->registerMetaService();
        $this->registerLabelService();
        $this->registerTypeService();
        $this->registerGroupeService();
        $this->registerRiiinglinkService();
        $this->registerInviteService();
        $this->registerAuthService();

	}

    /**
     * Auth
     */
    protected function registerAuthService(){

        $this->app->bind( 'Illuminate\Contracts\Auth\Registrar', 'App\Services\Registrar');
    }

    /**
     * User
     */
    protected function registerUserService(){

        $this->app->bind('\App\Riiingme\User\Repo\UserInterface', function()
        {
            return new \App\Riiingme\User\Repo\UserEloquent(new User);
        });
    }

    /**
     * Metas
     */
    protected function registerLabelService(){

        $this->app->bind('\App\Riiingme\Label\Repo\LabelInterface', function()
        {
            return new \App\Riiingme\Label\Repo\LabelEloquent(new Label);
        });
    }

    /**
     * Link metas
     */
    protected function registerMetaService(){

        $this->app->bind('\App\Riiingme\Meta\Repo\MetaInterface', function()
        {
            return new \App\Riiingme\Meta\Repo\MetaEloquent(new Meta);
        });
    }

    /**
     * Types
     */
    protected function registerTypeService(){

        $this->app->bind('\App\Riiingme\Type\Repo\TypeInterface', function()
        {
            return new \App\Riiingme\Type\Repo\TypeEloquent(new Type);
        });
    }

    /**
     * Groupe
     */
    protected function registerGroupeService(){

        $this->app->bind('\App\Riiingme\Groupe\Repo\GroupeInterface', function()
        {
            return new \App\Riiingme\Groupe\Repo\GroupeEloquent(new Groupe);
        });
    }

    /**
     * Riiinglink
     */
    protected function registerRiiinglinkService(){

        $this->app->bind('\App\Riiingme\Riiinglink\Repo\RiiinglinkInterface', function()
        {
            return new \App\Riiingme\Riiinglink\Repo\RiiinglinkEloquent(new Riiinglink);
        });
    }

    /**
     * Invite
     */
    protected function registerInviteService(){

        $this->app->bind('\App\Riiingme\Invite\Repo\InviteInterface', function()
        {
            return new \App\Riiingme\Invite\Repo\InviteEloquent(new Invite);
        });
    }


}
