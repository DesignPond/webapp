<?php namespace App\Http\Controllers;

use App\Riiingme\Invite\Repo\InviteInterface;
use App\Riiingme\User\Repo\UserInterface;

use App\Http\Requests\TokenRequest;
use App\Http\Requests\InviteRequest;
use App\Http\Requests\SendInviteRequest;

use App\Commands\ActivateAccount;
use App\Commands\ConfirmInvite;
use App\Commands\SendInvite;

class DispatchController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Activate the account
	 * @param  $request
	 * @return Response
	 */
    public function activation(TokenRequest $request)
    {

        $this->dispatch(new ActivateAccount($request->token));

        return redirect('/user')->with(array('status' => 'success', 'message' => 'Vous êtes maintenant inscrit'));

    }

    /**
     * Retrive invite
     * @param  $request
     * @return Response
     */
    public function invite(InviteRequest $request)
    {
        $this->dispatch(new ConfirmInvite($request->token, $request->ref));

        return redirect('/user')->with(array('status' => 'success', 'message' => 'L\'invitation est confirmé'));

    }


    /**
     * Activate newsletter abo
     * @param  $request
     * @return Response
     */
    public function send(SendInviteRequest $request)
    {

        $this->dispatch(new SendInvite($request->email, $request->user_id, $request->partage_host, $request->partage_invited));

        return redirect('user/partage')->with(array('status' => 'success', 'message' => 'Votre invitation a bien été envoyé'));

    }

}
