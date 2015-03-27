<?php namespace App\Http\Controllers;

use App\Riiingme\Meta\Worker\MetaWorker;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;
use Illuminate\Http\Request;

class MetasController extends Controller {

    protected $meta;
	protected $update;
	protected $riiinglink;

    public function __construct(RiiinglinkWorker $riiinglink, MetaWorker $meta)
    {
		$this->meta       = $meta;
		$this->riiinglink = $riiinglink;
    }

	/**
	 * List all metas for Riiinglink
	 * GET /metas
	 *
	 * @param  int $riiinglink
	 * @return json
	 */
	public function index(Request $request)
	{
		if($request->input('riiinglink_id'))
		{
			$metas = $this->meta->getMetasForRiiinglink(Input::get('riiinglink_id'));
		}

	}

	/**
	 * Store a new label for user
	 * POST /metas
	 *
	 * @return json
	 */
	public function store(Request $request)
	{

		try
		{
			$this->creation->validate($request->all());
		}
		catch (FormValidationException $e)
		{
			return $this->errorWrongArgs('Il manque des arguments');
		}

		$meta = $this->meta->createMeta( $request->all() );

		return $this->respondWithItem($meta, new MetaTransformer);

	}

	/**
	 * Return a specified label
	 * GET /metas/{id}
	 *
	 * @param  int $id
	 * @return json
	 */
	public function show($id)
	{
		$meta = $this->meta->getMeta($id);
	}

	/**
	 * Return the specified label
	 * PUT /metas/{id}
	 *
	 * @param  int  $id
	 * @return json
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified label
	 * DELETE /metas/{id}
	 *
	 * @param  int  $id
	 * @return json
	 */
	public function destroy($id)
	{
		if(!$this->meta->deleteMeta($id)){
		}
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
        $unser = $metas;
        $metas = serialize($metas);
        $metas = $this->riiinglink->setMetasForRiiinglink($id,$metas);

		return \Response::json($unser,200);

	}

}