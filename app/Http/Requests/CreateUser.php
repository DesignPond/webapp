<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUser extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'first_name' => 'required_if:user_type,private',
            'last_name'  => 'required_if:user_type,private',
            'company'    => 'required_if:user_type,company',
            'user_type'  => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed'
		];
	}

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required_if'  => 'Un Prénom est requis avec un compte privé',
            'last_name.required_if'   => 'Un nom est requis avec un compte privé',
            'company.required_if'     => 'Un nom est requis avec un compte d\'entreprise',
            'email.required'          => 'Le champs E-mail est requis'
        ];
    }

}
