<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Activite\Worker\ActiviteWorker;
use App\Riiingme\Export\Worker\ExportWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use Illuminate\Http\Request;

class ExportController extends Controller {

    protected $activity;
    protected $auth;
    protected $user;
    protected $groupe;
    protected $export;
    protected $riiinglink;

    public function __construct(UserInterface $user,ExportWorker $export, ActiviteWorker $activity, GroupeWorker $groupe, RiiinglinkInterface $riiinglink)
    {
        $this->activity   = $activity;
        $this->export     = $export;
        $this->user       = $user;
        $this->groupe     = $groupe;
        $this->riiinglink = $riiinglink;

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
        $riiinglinks = $this->riiinglink->count($this->auth->id);

        return view('backend.export.index')->with($depedencies + array('tags' => $tags, 'riiinglinks' => $riiinglinks));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function contacts(Request $request)
	{

        $tags    = $request->input('tags');
        $labels  = $request->input('labels');
        $groupes = $request->input('groupes');

        $this->export->setUser($this->auth->id)->setTags($tags)->setLabels($labels)->setGroupes($groupes)->getUserRiiinglinks();
        $this->export->setTypes();

        $types = $this->export->prepareLabelsTitle();
        $lines = $this->export->userExport();
        
        \Excel::create('Filename', function($excel) use ($lines,$types) {

            $excel->sheet('Export', function($sheet) use ($lines,$types) {
                $sheet->fromArray($lines);
                $sheet->row(1,[null,null,null,null,null,null,null,null,null,null,null,null,null]);
                $sheet->row(1,$types);
            });

        })->export('xls');
	}

}
