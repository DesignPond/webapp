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

        $users = $this->user->getAll('week');

        $all = $this->changes->getUsersHasUpdate('week');


        echo '<pre>';
        print_r($all);
        echo '</pre>';

        foreach ($users as $user)
        {
            $invited = $user->load('riiinglinks')->riiinglinks->lists('invited_id');

            $intersect = array_intersect($all,$invited);

            echo '<pre>';
            print_r($invited);
            print_r($intersect);
            echo 'end';
            echo '</pre>';

            //$changes  = $this->changes->getChangesConverted($user->id,'week');

  /*          if(!empty($invited))
            {
                foreach($invited as $invite)
                {
                    $revision = $this->changes->getLabelChanges($invite,'week');
                }
            }*/

         //    \Event::fire(new \App\Events\CheckChanges($user));
        }


        $changes  = $this->changes->getChangesConverted(1,'week');
        $revision = $this->changes->getLabelChanges(25,'week');


/*        foreach($updates as $update)
        {
            echo '<ul>';
           // echo  '<li> '.$update->user_id.'</li>';
            echo '</ul>';
        }*/


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
