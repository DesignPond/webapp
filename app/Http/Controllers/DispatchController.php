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

        return redirect('/user')->with(array('status' => 'success', 'message' => 'Votre compte est maintenant actif!'));

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

            return redirect('user/link/'.$result['link'])->with(array('status' => 'success', 'message' => 'L\'invitation est confirmé'));
        }
        elseif($result['status'] == 'register')
        {
            session(['invite_id' => $result['invite_id'] ,'email' => $result['email']]);

            return redirect('auth/register');
        }
        else
        {
            return redirect('/')->with(array('error' => 'Problem avec le jeton'));
        }

    }

    /**
     * Send invitation
     * @param  $request
     * @return Response
     */
    public function send(SendInviteRequest $request)
    {
        /*
            $pos = strpos($haystack,$needle);

            if($pos === false) {
             // string needle NOT found in haystack
            }
            else {
             // string needle found in haystack
            }
        */
        $this->dispatch(new SendInvite($request->email, $request->user_id, $request->partage_host, $request->partage_invited));

        return redirect('user/partage')->with(array('status' => 'success', 'message' => 'Votre invitation a bien été envoyé'));
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

        return redirect('auth/activate')->with(array('status' => 'success', 'message' => 'Votre lien d\'activation a bien été envoyé'));
    }

}
