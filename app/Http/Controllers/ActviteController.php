<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Activite\Worker\ActiviteWorker;

use Illuminate\Http\Request;

class ActviteController extends Controller {

    protected $groupe;
    protected $user;
    protected $activity;
    protected $auth;

    public function __construct(UserInterface $user, GroupeWorker $groupe, ActiviteWorker $activity)
    {

        $this->user       = $user;
        $this->groupe     = $groupe;
        $this->activity   = $activity;

        $this->auth = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);

    }

    /**
     * Show the timeline
     * GET /user/timeline
     *
     * @return Response
     */
    public function index()
    {
        $activity = $this->activity->getPaginate($this->auth->id, 0, 6);
        $total    = $this->activity->getTotal($this->auth->id);

        return view('backend.timeline')->with(array('activity' => $activity, 'total' => $total));
    }

    /**
     * Show partage form
     * GET /user/partage
     *
     * @return Response
     */
    public function partage()
    {
        $invites     = $this->activity->getPendingInvites($this->auth->id);
        $depedencies = $this->groupe->getDependencies($this->auth->user_type);

        return view('backend.partage')->with($depedencies + array('invites' => $invites));
    }

    /**
     * Prepare the timeline
     * POST /activites
     *
     * @return Response
     */
    public function activites(Request $request)
    {
        $activity = $this->activity->getPaginate($this->auth->id, $request->skip, $request->take);

        echo view('backend.partials.activite', ['activity' => $activity]);
    }

}
