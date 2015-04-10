<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory;

class SendInviteRequest extends Request {

    protected $label;

    public function __construct(Factory $factory)
    {

        $this->label = \App::make('App\Riiingme\Label\Repo\LabelInterface');

        $factory->extend('labels', function ($attribute, $value, $parameters)
        {
            $user_id = $this->data['user_id'];
            $labels  = $this->label->findByUser($user_id);

            return ($labels->isEmpty() ? false : true);
        },
            'Veuillez remplir vos informations'
        );
    }

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
            'email'        => 'required',
            'user_id'      => 'required|exists:users,id|labels'
		];
	}

}
