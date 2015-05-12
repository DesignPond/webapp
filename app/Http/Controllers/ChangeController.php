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
        // Get all users who want notifications every week
        $users = $this->user->getAll('week');

        // Get all users who have made updates last week
        $all   = $this->changes->setPeriod('week')->getUsersHaveUpdate();

        foreach ($users as $user)
        {
            // Load user riiinglinks to get all invited
            $invited   = $user->load('riiinglinks')->riiinglinks->lists('invited_id');

            // If the invited have updates get them
            $intersect = array_intersect($all,$invited);

            if(!empty($intersect))
            {

                $this->changes->setUser($user->id)->setPeriod($user->notification_interval);
                $data = $this->changes->allChanges();

                echo '<div style="display: block;padding: 5px;margin: 10px; width: 500px; background: #ccc;">';
                    echo '<p>User: '.$user->id.'</p>';
                    echo '<p>For:</p>';
                    echo '<pre>';
                    print_r($intersect);

                    $ids = $this->user->getEmails($intersect);
                    echo '</pre>';
                    echo '<pre>';
                    print_r($ids);
                    echo '</pre>';
                echo '</div>';

            }

            /*
              //$changes  = $this->changes->getChangesConverted($user->id,'week');

              if(!empty($invited))
              {
                  foreach($invited as $invite)
                  {
                      $revision = $this->changes->getLabelChanges($invite,'week');
                  }
              }

            */

            // \Event::fire(new \App\Events\CheckChanges($user));
        }

        /*
        foreach($updates as $update)
        {
            echo '<ul>';
           // echo  '<li> '.$update->user_id.'</li>';
            echo '</ul>';
        }
        */
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
