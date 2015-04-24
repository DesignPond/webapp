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
        $this->upload = $upload;
        $this->label  = $label;
    }

    public function updatePhoto(Request $request)
    {

        $file = $this->upload($request->file('file'));

        if($file)
        {
            $user_id  = base64_decode($request->input('token_id'));
            $photo    = $file['name'];
            $label_id = $request->input('label_id',null);

            $this->label->updatePhoto($user_id,$photo,$label_id);

            return $photo;
        }
    }

    public function upload($file)
    {
        $files = $this->upload->upload( $file , 'users' );

        if($files)
        {
            return $files;
        }

        return false;
    }

}
