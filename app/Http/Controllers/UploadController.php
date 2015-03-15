<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Service\Upload\UploadWorker;

use Illuminate\Http\Request;

class UploadController extends Controller {

    protected $upload;

    public function __construct( UploadWorker $upload )
    {
        $this->middleware('auth');

        $this->upload = $upload;
    }

    public function upload(Request $request)
    {

        $files = $this->upload->upload( $request->file('file') , 'users' );

        if($files)
        {
            return \Response::json(array(
                'success' => true,
                'files'   => $request->file('file'),
                'get'     => $request->all(),
                'post'    => $request->all()
            ), 200 );
        }

        return false;

    }

}
