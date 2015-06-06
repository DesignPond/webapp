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
            $labels  = $this->label->findByUser($value);

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
            'email_new'    => 'required_without:email_exist|email',
            'email_exist'  => 'required_without:email_new|email',
            'user_id'      => 'required|exists:users,id|labels'
		];
	}

}
