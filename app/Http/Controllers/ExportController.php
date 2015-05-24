<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Label\Worker\LabelWorker;
use App\Riiingme\Export\Worker\ExportWorker;
use Illuminate\Http\Request;

class ExportController extends Controller {

    protected $riiinglink;
    protected $groupe;
    protected $auth;
    protected $label;
    protected $export;

    public function __construct(ExportWorker $export, GroupeWorker $groupe, RiiinglinkInterface $riiinglink, LabelWorker $label)
    {
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;
        $this->label      = $label;
        $this->export     = $export;
        $this->auth       = \Auth::user()->id;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $this->export->setUser($this->auth)->getUserRiiinglinks();
        $this->export->setTypes()->unsetHiddenTypes();

        $lines = $this->export->userExport();
        
        \Excel::create('Filename', function($excel) use ($lines) {

            $excel->sheet('Export', function($sheet) use ($lines) {
                $sheet->fromArray($lines);
                $sheet->row(1,['Pénom et nom', 'Email', 'Entreprise', 'Profession', 'Rue et Numéro', 'NPA','Ville','Pays','Téléphone fixe','Téléphone portable','Date de naissance','Site web']);
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
