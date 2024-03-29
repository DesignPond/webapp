<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\TokenRequest;
use App\Http\Requests\InviteRequest;
use App\Http\Requests\SendInviteRequest;
use App\Riiingme\User\Repo\UserInterface;

use App\Commands\ActivateAccount;
use App\Commands\ConfirmInvite;
use App\Commands\SendInvite;

class DispatchController extends Controller {

    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

	/**
	 * Activate the account
	 * @param  $request
	 * @return response
	 */
    public function activation(Request $request)
    {
        $this->dispatch(new ActivateAccount($request->input('token')));

        return redirect('/user')->with(array('status' => 'success', 'message' => trans('message.profile_active') ));
    }

    /**
     * Retrive invite
     * @param  $request
     * @return Response
     */
    public function invite(InviteRequest $request)
    {
        $result = $this->dispatch(new ConfirmInvite($request->token, $request->ref));
        
        if($result['status'] == 'confirmed')
        {
            // Log in the user
            \Auth::loginUsingId($result['user']->id);

            return redirect('user/link/'.$result['link'])->with(array('status' => 'success', 'message' => trans('message.invite_confirmed') ));
        }
        elseif($result['status'] == 'register')
        {
            session(['invite_id' => $result['invite_id'] ,'email' => $result['email']]);

            return redirect('auth/register');
        }
        else
        {
            return redirect('/')->with(array('error' => trans('message.token_mismatch') ));
        }

    }

    public function sendEmail($email,$request)
    {
        $validator = \Validator::make(['email' => $email] , [ 'email' => 'email' ]);

        if ($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with( array('status' => 'danger'));
        }

        $this->dispatch(new SendInvite($email, $request->user_id, $request->partage_host, $request->partage_invited));
    }

    /**
     * Send invitation
     * @param  $request
     * @return Response
     */
    public function send(SendInviteRequest $request)
    {
        $multiple  = $request->multiple;

        if(!empty($multiple))
        {
            $emails = array_map('trim', explode(',', $request->multiple));

            if(!empty($emails))
            {
                if(in_array(\Auth::user()->email,$emails) && count($emails) == 1)
                {
                    return redirect('user/partage')->with(array('status' => 'danger', 'message' => trans('message.no_self_send') ));
                }

                foreach($emails as $email)
                {
                    if($email != \Auth::user()->email)
                    {
                        $this->sendEmail($email,$request);
                    }
                }
            }
        }
        else
        {
            if($request->email != \Auth::user()->email)
            {
                $this->sendEmail($request->email, $request);
            }
            else
            {
                return redirect('user/partage')->with(array('status' => 'danger', 'message' => trans('message.no_self_send') ));
            }
        }

        return redirect('user/partage')->with(array('status' => 'success', 'message' => trans('message.send_invite_ok') ));
    }

    /**
     * Activate account
     * @param  $request
     * @return Response
     */
    public function sendActivationLink()
    {
        $user = $this->user->find(\Auth::user()->id);

        \Mail::send('emails.confirmation', ['name' => $user->name, 'user_photo' => $user->user_photo, 'token' => $user->activation_token] , function($message) use ($user)
        {
            $message->to($user->email)->subject('Confirmation');
        });

        return redirect('auth/activate')->with(array('status' => 'success', 'message' => trans('message.send_link_active') ));
    }

}
