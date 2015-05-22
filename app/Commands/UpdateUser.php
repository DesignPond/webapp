<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class UpdateUser extends Command implements SelfHandling {

    protected $label;
    protected $user;
    protected $infos;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($infos)
	{
        $this->infos = $infos;
        $this->user  = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->label = \App::make('App\Riiingme\Label\Repo\LabelInterface');


	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        $factory = \App::make('Illuminate\Validation\Factory');

        $factory->extend('search_by', function ($attribute, $value, $parameters)
        {
            return ( ($this->infos['email_search'] == 0) && ($this->infos['name_search'] == 0) ? false : true );
        });

        $validator = \Validator::make(
            $this->infos , [
                'first_name'   => 'required_if:user_type,private',
                'last_name'    => 'required_if:user_type,private',
                'company'      => 'required_if:user_type,company',
                'email_search' => 'search_by'
            ],
            [
                'email_search.search_by' => 'Vous devez autoriser au moins un champs de recherche',
            ]
        );

        if ($validator->fails() || ($this->infos['name_search'] == 0 && $this->infos['email_search'] == 0))
        {
            return redirect()->back()->withErrors($validator->errors())->with( array('status' => 'danger' , 'message' => '') );
        }

        $user = $this->user->find($this->infos['id']);

        if($this->infos['email'] != $user->email)
        {
            $used = $this->user->findByEmail($this->infos['email']);

            if($used)
            {
                return redirect()->back()->with( array('status' => 'error' , 'message' => 'Cet email est déjà utilisé') );
            }
            else
            {
                $this->user->update(array('id' => $this->infos['id'] ,'email' => $this->infos['email']));
                
                $email = $this->label->findByUserGroupeType($user->id,2,1);

                if(!$email->isEmpty())
                {
                    $email = $email->first();
                    $email->label = $this->infos['email'];
                    $email->save();
                }
            }
        }

        return $this->user->update($this->infos);

    }

}
