<?php namespace App\Http\Controllers;

use App\Riiingme\Meta\Repo\MetaInterface;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use Illuminate\Http\Request;

class MetasController extends Controller {

    protected $meta;
	protected $riiinglink;

    public function __construct(RiiinglinkWorker $riiinglink, MetaInterface $meta)
    {
		$this->meta       = $meta;
		$this->riiinglink = $riiinglink;
    }

	/**
	 * Update metas
	 *
	 * @param  array $data
	 * @return json
	 */
	public function updateMetas(Request $request)
	{
		parse_str($request->input('riiinglink'), $data);

		$id    = $data['riiinglink_id'];
		$metas = $data['metas'];

        $meta  = $this->meta->findByRiiinglink($id);

        if(!$meta->isEMpty())
        {
            $meta = $meta->first();
            $meta->labels = serialize($metas);
            $meta->save();
        }
        else
        {
            $this->meta->create([ 'riiinglink_id' => $id,  'labels'  => serialize($metas) ]);
        }

		return \Response::json($metas,200);

	}

}