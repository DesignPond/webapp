<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\TokenRequest;
use App\Http\Requests\InviteRequest;
use App\Http\Requests\SendInviteRequest;

use App\Commands\ActivateAccount;
use App\Commands\ConfirmInvite;
use App\Commands\SendInvite;

class DispatchController extends Controller {

    public function __construct()
    {
        $this->middleware('guest');
    }

	/**
	 * Activate the account
	 * @param  $request
	 * @return response
	 */
    public function activation(Request $request)
    {

        $this->dispatch(new ActivateAccount($request->input('token')));

        return redirect('/user')->with(array('status' => 'success', 'message' => 'Votre compta est maintenant actif!'));

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
            return redirect('/user')->with(array('status' => 'success', 'message' => 'L\'invitation est confirmé'));
        }
        elseif($result['status'] == 'register')
        {
            session(['invite_id' => $result['invite_id'] ,'email' => $result['email']]);

            return redirect('auth/register');
        }
        else{
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

        \Event::fire(new \App\Events\AccountWasCreated(\Auth::user()));

        return redirect('user')->with(array('status' => 'success', 'message' => 'Votre lien d\'activation a bien été envoyé'));

    }

}
