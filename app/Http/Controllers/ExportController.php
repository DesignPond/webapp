<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use Illuminate\Http\Request;

class ExportController extends Controller {

    protected $riiinglink;
    protected $groupe;
    protected $auth;

    public function __construct(GroupeWorker $groupe, RiiinglinkInterface $riiinglink)
    {
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;
        $this->auth       = \Auth::user()->id;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $groupes     = $this->groupe->getGroupes();
        $riiinglinks = $this->riiinglink->findByHost($this->auth);

        $data = [];

        if(!$riiinglinks->isEMpty())
        {
            foreach($riiinglinks->toArray() as $riiinglink)
            {
                $user   = array_values($riiinglink['invite']);
                $data[] = $user;
            }
        }

        $data = array_values($data);



        \Excel::create('Filename', function($excel) use ($data) {

            $excel->sheet('Export', function($sheet) use ($data) {

                $sheet->fromArray( $data );

            });

        })->export('xls');

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
