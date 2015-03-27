<?php namespace App\Services;

use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use App\Commands\CreateAccount;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
            'first_name' => 'required_if:user_type,private|max:255',
            'last_name'  => 'required_if:user_type,private|max:255',
            'company'    => 'required_if:user_type,company|max:255',
            'user_type'  => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6'
		],
        [
            'first_name.required_if' => 'Pour un compte privé le prénom est requis',
            'last_name.required_if'  => 'Pour un compte privé le nom est requis',
            'company.required_if'    => 'Pour un compte entreprise un nom est requis',
            'email.unique'           => 'Cet email est déjà utilisé',
        ]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
        return $this->dispatch(new CreateAccount($data));
	}

}
