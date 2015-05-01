<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Activite\Worker\ChangeWorker;
use App\Riiingme\User\Repo\UserInterface;

use Illuminate\Http\Request;

class ChangeController extends Controller {

    protected $user;

    public function __construct(ChangeWorker $change, UserInterface $user){

        $this->changes = $change;
        $this->user    = $user;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $users = $this->user->getAll();

        foreach ($users as $user)
        {
             \Event::fire(new \App\Events\CheckChanges($user));
        }

        $changes  = $this->changes->getChanges(1,'week');
        $revision = $this->changes->getLabelChange(1,'week');
        $labels   = $this->changes->convertToLabels($changes);

        foreach($revision as $label){
            echo '<ul>';
            echo  '<li>'. $label->label->load('type')->type->titre  .': '.$label->new_value.'</li>';
            echo '</ul>';
        }

        echo '<pre>';
        print_r($labels);
       // print_r($revision);
        echo '</pre>';
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
