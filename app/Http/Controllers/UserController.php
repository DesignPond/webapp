<?php namespace App\Http\Controllers;

use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\User\Worker\UserWorker;
use App\Riiingme\Label\Worker\LabelWorker;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Tag\Repo\TagInterface;
use App\Riiingme\Activite\Worker\ActiviteWorker;

use App\Http\Requests\UpdateUserRequest;
use App\Commands\UpdateUser;
use App\Commands\UpdateLabelUser;

use Illuminate\Http\Request;

class UserController extends Controller {

	protected $riiinglink;
	protected $label;
	protected $groupe;
	protected $user;
    protected $worker;
	protected $activity;
    protected $auth;
    protected $tags;

	public function __construct(UserInterface $user, UserWorker $worker, TagInterface $tags, RiiinglinkWorker $riiinglink, LabelWorker $label, GroupeWorker $groupe, ActiviteWorker $activity)
	{
		$this->user       = $user;
        $this->worker     = $worker;
		$this->riiinglink = $riiinglink;
		$this->label      = $label;
		$this->groupe     = $groupe;
		$this->activity   = $activity;
        $this->tags       = $tags;

        $this->auth = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);

        $demandes = $this->activity->getAskInvites($this->auth->email);
        \View::share('demandes', $demandes);

	}

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

        $tags = $this->auth->user_tags->lists('title','id');

        $riiinglinks = $this->riiinglink->getRiiinglinkWithParams($this->auth->id,$request);

        return view('backend.show')->with(array('riiinglinks' => $riiinglinks, 'tags' => $tags, 'filtres' => $request->all()));

	}

    public function activites()
    {
        $latest    = $this->riiinglink->getLatest($this->auth->id);
        $activity  = $this->activity->getPaginate($this->auth->id, 0, 8);

        return view('backend.index')->with(array( 'activity' => $activity, 'latest' => $latest));
    }

    /**
     * Update labels
     * PUT /user/labels
     *
     * @return Response
     */
    public function labels(UpdateUserRequest $request)
    {

        $this->dispatch(new UpdateUser($request->info));
        $result = $this->dispatch(new UpdateLabelUser($request->edit,$request->label, $request->date));

        $status = \Session::get('status');

        if($status != 'danger')
        {
            //$this->worker->proceesPendingInvites(\Auth::user()->id);

            return redirect('user/'.$this->auth->id.'/edit')->with( array('status' => 'success' , 'message' => trans('message.info_maj') ) );
        }

        return redirect('user/'.$this->auth->id.'/edit')->with( array('status' => 'danger' , 'message' =>  trans('message.info_problem_maj') ) );
    }

	/**
	 * Show the form for editing the specified resource.
	 * GET /user/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$labels      = $this->label->labelByGroupeType($id);
        $depedencies = $this->groupe->getDependencies($this->auth->user_type);

		return view('backend.edit')->with($depedencies + array('labels' => $labels));
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}