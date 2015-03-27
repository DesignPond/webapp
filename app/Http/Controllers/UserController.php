<?php namespace App\Http\Controllers;

use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\Meta\Worker\MetaWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Label\Worker\LabelWorker;
use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Type\Repo\TypeInterface;
use App\Riiingme\Service\Activity\ActivityWorker;
use App\Riiingme\Invite\Repo\InviteInterface;
use App\Riiingme\Country\Repo\CountryInterface;

use App\Http\Requests\UpdateUserRequest;
use App\Commands\UpdateUser;
use App\Commands\UpdateLabelUser;

use Illuminate\Http\Request;

class UserController extends Controller {

	protected $riiinglink;
	protected $meta;
	protected $label;
	protected $groupe;
	protected $type;
	protected $user;
	protected $activity;
	protected $invite;
    protected $auth;
    protected $helper;
    protected $country;

	public function __construct(UserInterface $user,CountryInterface $country, RiiinglinkWorker $riiinglink, MetaWorker $meta, LabelWorker $label, GroupeInterface $groupe, TypeInterface $type, InviteInterface $invite, ActivityWorker $activity)
	{

        $this->helper     = new \App\Riiingme\Helpers\Helper;
		$this->user       = $user;
		$this->riiinglink = $riiinglink;
		$this->meta       = $meta;
		$this->label      = $label;
		$this->groupe     = $groupe;
		$this->type       = $type;
		$this->activity   = $activity;
		$this->invite     = $invite;
        $this->country    = $country;

        $this->auth = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);

		$groupes       = $this->groupe->getAll()->lists('titre','id');
        $status        = $this->groupe->getAll()->lists('status','id');
		$groupe_type   = $this->groupe->getAll($this->auth->user_type)->toArray();
		$types         = $this->type->getAll()->lists('titre','id');
        $groupes_user  = $this->groupe->getAll($this->auth->user_type)->lists('titre','id');

		\View::share('groupes', $groupes);
        \View::share('status', $status);
		\View::share('groupe_type', $groupe_type);
        \View::share('groupes_user', $groupes_user);
		\View::share('types', $types);

	}

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{

		$ringlinks = $this->riiinglink->getRiiinglinks($this->auth->id);
		$activity  = $this->activity->getActivity($this->auth->id);

		if(!empty($ringlinks)){
			$ringlinks = array_slice($ringlinks['data'],0,6);
		}

		return view('backend.index')->with(array('ringlinks' => $ringlinks, 'activity' => $activity));

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function partage()
	{
		$invites = $this->activity->getInvites($this->auth->id);

		return view('backend.partage')->with(array('invites' => $invites));
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

		list($ringlink,$items) = $this->riiinglink->getRiiinglinkWithParams($id,$request);

		return view('backend.show')->with(array('ringlink' => $ringlink, 'items' => $items));
	}

	/**
	 * Display the specified resource.
	 * GET /user/link/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function link($id)
	{
        // Get riiinglink from id
        $link = $this->riiinglink->riiinglinkItem($id);

        // Test if id is user_id from riinglink
        if($this->auth->id != $link->host_id)
        {
            return redirect('/');
        }

        // Get metas
		$metas     = $this->meta->getMetas($id);

		$ringlink  = $this->riiinglink->getRiiinglinks($id,true);
		$ringlink  = $this->riiinglink->convert($ringlink, $this->auth->labels->toArray());

		$labels    = $this->riiinglink->convertToGroupLabel();

        return view('backend.link')->with(array('ringlink' => $ringlink, 'metas' => $metas , 'labels' => $labels));
	}

    /**
     * Update labels
     * PUT /user/labels
     *
     * @return Response
     */
    public function labels(UpdateUserRequest $request)
    {
       /* $four = $request->all();
        echo '<pre>';
        print_r($four);
        echo '</pre>';exit;*/

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

		$labels  = $this->label->labelByGroupeType($id);
        $country = $this->country->getAll()->lists('phonecode','id');

		return view('backend.edit')->with(array('labels' => $labels, 'country' => $country));
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