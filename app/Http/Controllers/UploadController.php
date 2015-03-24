<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Riiingme\Service\Upload\UploadWorker;
use App\Riiingme\Label\Worker\LabelWorker;

use Illuminate\Http\Request;

class UploadController extends Controller {

    protected $upload;
    protected $label;

    public function __construct( UploadWorker $upload, LabelWorker $label )
    {
        $this->middleware('auth');

        $this->upload = $upload;
        $this->label  = $label;
    }

    public function upload(Request $request)
    {

        $files = $this->upload->upload( $request->file('file') , 'users' );

        if($files)
        {
            return \Response::json(array(
                'success' => true,
                'files'   => $files['name'],
                'get'     => $request->all(),
                'post'    => $request->all()
            ), 200 );

            $user_id = base64_decode($request->input('token_id'));
            $photo   = $files['name'];
            $label   = $request->input('label',null);


        }

        return false;
    }

    public function photo($user_id,$photo,$label = null){

    }

}
