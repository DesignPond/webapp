<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Label\Worker\LabelWorker;
use Illuminate\Http\Request;

class ExportController extends Controller {

    protected $riiinglink;
    protected $groupe;
    protected $auth;
    protected $label;

    public function __construct(GroupeWorker $groupe, RiiinglinkInterface $riiinglink, LabelWorker $label)
    {
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;
        $this->label      = $label;
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
        $user_data   = [];

        if(!$riiinglinks->isEMpty())
        {
            foreach($riiinglinks as $riiinglink)
            {
                $data   = [];
                $invite = $riiinglink->invite->load('labels','users_groups');
                $labels = $invite->labels;

                foreach($labels as $groupe)
                {
                    if($groupe->groupe_id > 1)
                    {
                        $data[$groupe->groupe_id][0] =  $invite->name;
                        $data[$groupe->groupe_id][$groupe->type_id] = $groupe->label;
                    }
                }

                $data = $this->label->periodIsInEffect($invite->users_groups,$data);

                $user_data[$riiinglink->invite->id] = $data;
            }
        }

        $lines = [];

        foreach($user_data as $data)
        {
           foreach($data as $line){
               $lines[] = $line;
           }
        }


        $data = array_values($data);

        \Excel::create('Filename', function($excel) use ($lines) {

            $excel->sheet('Export', function($sheet) use ($lines) {

                $sheet->fromArray( $lines );

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
