<?php namespace App\Http\Controllers;

use App\Riiingme\Meta\Repo\MetaInterface;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use App\Riiingme\Label\Worker\LabelWorker;
use App\Riiingme\User\Repo\UserInterface;
use Illuminate\Http\Request;

class MetasController extends Controller {

    protected $meta;
	protected $riiinglink;

    public function __construct(RiiinglinkWorker $riiinglink, MetaInterface $meta, LabelWorker $label, UserInterface $user)
    {
		$this->meta       = $meta;
		$this->riiinglink = $riiinglink;
        $this->label      = $label;
        $this->user       = $user;
        $this->auth       = $this->user->find(\Auth::user()->id);
    }

	/**
	 * Update metas
	 *
	 * @param  array $data
	 * @return json
	 */
	public function update(Request $request)
	{
		parse_str($request->input('riiinglink'), $data);

		$id = $data['riiinglink_id'];

        if(isset($data['metas']))
        {
            $metas = $data['metas'];
            $meta  = $this->meta->findByRiiinglink($id);

            if(!$meta->isEmpty())
            {
                $meta = $meta->first();
                $meta->labels  = serialize($metas);

                $meta->save();
            }
            else
            {
                $this->meta->create([
                    'riiinglink_id' => $id,
                    'labels'        => serialize($metas)
                ]);
            }

            return \Response::json($metas,200);
        }

        return \Response::json('',200);

	}

    /**
     * Update date range for groupe
     *
     * @return Response
     */
    public function updatePeriod(Request $request)
    {
        $groupe = $request->input('groupe');
        $date   = $request->input('date');

        $this->label->updatePeriodRange($this->auth, $groupe, $date);

        echo 'ok';
    }

}