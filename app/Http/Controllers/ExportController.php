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

    public $exportLines;
    public $exportTypes;
    public $exportConfig;

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

    public function setConfig()
    {

        $all = config('badge');

        if(isset($all['avery_L4744REV']))
        {
            $this->exportConfig = $all['avery_L4744REV'];
        }

        return $this;
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
	 *
	 * @return Response
	 */
	public function contacts(Request $request)
	{

        $tags    = $request->input('tags');
        $labels  = $request->input('labels');
        $groupes = $request->input('groupes');

        $this->exportData($tags, $labels, $groupes);

        $types = $this->exportTypes;
        $lines = $this->exportLines;
        
        \Excel::create('Exportation', function($excel) use ($lines,$types) {

            $excel->sheet('Export', function($sheet) use ($lines,$types) {
                $sheet->fromArray($lines);
                $sheet->row(1,[null,null,null,null,null,null,null,null,null,null,null,null,null]);
                $sheet->row(1,$types);
            });

        })->export('xls');
	}

    public function exportData($tags = null, $labels = null, $groupes = null)
    {
        $this->export->setUser($this->auth->id)->setTags($tags)->setLabels($labels)->setGroupes($groupes)->getUserRiiinglinks();
        $this->export->setTypes();

        $this->exportLines = $this->export->userExport();
        $this->exportTypes = $this->export->prepareLabelsTitle();

        return $this;
    }

    public function exportLabels()
    {
        $this->exportData(null, [1], null);
        $data = $this->export->chunkData($this->exportLines,2,8);

/*        echo '<pre>';
        print_r($data);
        echo '</pre>';*/

        $data = $this->fake();

        $this->setConfig();

        $config = ['cols' => $this->exportConfig['cols'], 'height' => $this->exportConfig['height'], 'margin' => $this->exportConfig['margin'], 'width' => $this->exportConfig['width'] ,'data' => $data];

        return \PDF::loadView('backend.export.bagde', $config)
            ->setPaper('a4')
            ->stream('download.pdf');
    }

    public function fake(){

        $fakerobj = new \Faker\Factory;
        $faker    = $fakerobj::create();

        for( $x = 1 ; $x < 16; $x++ )
        {
            $data[] = [$faker->name];
        }

        return $this->export->chunkData($data,2,10);
    }
}
