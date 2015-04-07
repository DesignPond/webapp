<?php namespace App\Http\Controllers;

use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\User\Repo\UserInterface;
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
	protected $activity;
    protected $auth;
    protected $tags;

	public function __construct(UserInterface $user, TagInterface $tags, RiiinglinkWorker $riiinglink, LabelWorker $label, GroupeWorker $groupe, ActiviteWorker $activity)
	{
		$this->user       = $user;
		$this->riiinglink = $riiinglink;
		$this->label      = $label;
		$this->groupe     = $groupe;
		$this->activity   = $activity;
        $this->tags       = $tags;

        $this->auth = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);

	}

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{

        $latest    = $this->riiinglink->getLatest($this->auth->id);
		$activity  = $this->activity->getPaginate($this->auth->id, 0, 6);

		return view('backend.index')->with(array( 'activity' => $activity, 'latest' => $latest));

	}

    /**
	 * Display the specified resource.
	 * GET /user/{id}
	 *
	 * @param  int  $id, $request
	 * @return Response
	 */
	public function show($id, Request $request)
	{
/*        echo '<pre>';
        print_r($request->all());
        echo '</pre>';*/

        $droptags = $this->tags->getAll($this->auth->id);

		list($pagination,$riiinglinks) = $this->riiinglink->getRiiinglinkWithParams($id,$request);

		return view('backend.show')->with(array('riiinglinks' => $riiinglinks, 'droptags' => $droptags,'pagination' => $pagination));
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
        $this->dispatch(new UpdateLabelUser($request->edit,$request->label, $request->date));

        return redirect('user/'.$this->auth->id.'/edit')->with( array('status' => 'success' , 'message' => 'Vos informations ont été mis à jour') );

    }

	/**
	 * Show the form for editing the specified resource.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('backend.create');
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