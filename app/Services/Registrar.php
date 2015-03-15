<?php namespace App\Services;

use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

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
		return \App\Riiingme\User\Entities\User::create([
			'email'       => $data['email'],
			'password'    => bcrypt($data['password']),
            'first_name'  => (isset($data['first_name']) && !empty($data['first_name']) ? $data['first_name'] : ''),
            'last_name'   => (isset($data['last_name']) && !empty($data['last_name']) ? $data['last_name'] : ''),
            'company'     => (isset($data['company']) && !empty($data['company']) ? $data['company'] : ''),
            'user_type'   => $data['user_type'],
		]);
	}

}
