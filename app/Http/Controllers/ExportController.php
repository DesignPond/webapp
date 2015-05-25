<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Activite\Worker\ActiviteWorker;
use App\Riiingme\Export\Worker\ExportWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use Illuminate\Http\Request;

class ExportController extends Controller {

    protected $activity;
    protected $auth;
    protected $user;
    protected $groupe;
    protected $export;

    public function __construct(UserInterface $user,ExportWorker $export, ActiviteWorker $activity, GroupeWorker $groupe)
    {
        $this->activity   = $activity;
        $this->export     = $export;
        $this->user       = $user;
        $this->groupe     = $groupe;

        $this->auth       = $this->user->find(\Auth::user()->id);
        \View::share('user',  $this->auth);

        $demandes = $this->activity->getAskInvites($this->auth->email);
        \View::share('demandes', $demandes);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $tags        = $this->auth->user_tags->lists('title','id');
        $depedencies = $this->groupe->getDependencies($this->auth->user_type);

        return view('backend.export.index')->with($depedencies + array('tags' => $tags));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function contacts()
	{

        $this->export->setUser($this->auth->id)->setTags([2])->getUserRiiinglinks();
        $this->export->setTypes()->unsetHiddenTypes();

        $lines = $this->export->userExport();

        \Excel::create('Filename', function($excel) use ($lines) {

            $excel->sheet('Export', function($sheet) use ($lines) {
                $sheet->fromArray($lines);
                $sheet->row(1,['Pénom et nom', 'Email', 'Entreprise', 'Profession', 'Rue et Numéro', 'NPA','Ville','Pays','Téléphone fixe','Téléphone portable','Date de naissance','Site web']);
            });

        })->export('xls');
	}

}
