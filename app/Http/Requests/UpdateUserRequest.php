<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        if (\Auth::check())
        {
            return true;
        }

        return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'email'      => 'unique:users',
            'first_name' => 'required_if:user_type,private',
            'last_name'  => 'required_if:user_type,private',
            'company'    => 'required_if:user_type,company',
		];
	}

}
