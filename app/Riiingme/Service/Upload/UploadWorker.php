<?php namespace App\Riiingme\Service\Upload;

use App\Riiingme\Exceptions\FileUploadException;

class UploadWorker implements UploadInterface {

	/*
	 * upload selected file 
	 * @return array
	*/	
	public function upload( $file , $destination , $type = null ){

        $user_id = \Auth::user()->id;

        try
        {
            $name = $file->getClientOriginalName();
            $ext  = $file->getClientOriginalExtension();

            $image_name =  basename($name,'.'.$ext);

            $string  = str_random(40);
            $string  = 'user_'.$user_id.'_'.$string;
            $newname = $string.'.'.$ext;

            // Get the name first because after moving, the file doesn't exist anymore
            $new  = $file->move($destination,$newname);

            $size = $new->getSize();
            $mime = $new->getMimeType();
            $path = $new->getRealPath();

            //resize
            $this->resize( $path, $path , 200, null , true );
            //$this->rename( $path , $newname , $destination );

            $newfile = array( 'name' => $newname ,'ext' => $ext ,'size' => $size ,'mime' => $mime ,'path' => $path );

            return $newfile;

        }
        catch(Exception $e)
        {
            throw new \App\Riiingme\Exceptions\FileUploadException('Upload failed', $e->getError() );
        }

	}
	
	/*
	 * rename file 
	 * @return instance
	*/	
	public function rename( $file , $name , $path ){

		$newpath = $path.$name;

        return \Image::make( $file )->save($newpath);

	}
	
	/*
	 * resize file 
	 * @return instance
	*/	
	public function resize( $path, $name , $width = null , $height = null){

        $img = \Image::make($path);

        // prevent possible upsizing
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save($path);
	}

    /*
     * Scan directory
     * @return array
    */
    public function scan($dir){

        $files = array();

        // Is there actually such a folder/file?
        if(file_exists($dir))
        {

            foreach(scandir($dir) as $f) {

                if(!$f || $f[0] == '.') {
                    continue; // Ignore hidden files
                }

                if(is_dir($dir . '/' . $f)) {

                    // The path is a folder
                    $files[] = array(
                        "name" => $f,
                        "type" => "folder",
                        "path" => $dir . '/' . $f,
                        "items" => $this->scan($dir . '/' . $f) // Recursively get the contents of the folder
                    );
                }
                else {
                    // It is a file
                    $files[] = array(
                        "name" => $f,
                        "type" => "file",
                        "path" => $dir . '/' . $f,
                        "size" => filesize($dir . '/' . $f) // Gets the size of this file
                    );
                }
            }
        }

        return $files;
    }
    
    
}