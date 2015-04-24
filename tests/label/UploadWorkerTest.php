<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class UploadWorkerTest extends TestCase {

    protected $mock;
    protected $upload;

    public function setUp()
    {
        parent::setUp();

        $this->refreshApplication();

        $this->mock = \Mockery::mock('App\Riiingme\Service\Upload\UploadInterface');
       // $this->app->instance('App\Riiingme\Service\Upload\UploadInterface', $this->mock);

        $this->upload = \App::make('App\Riiingme\Service\Upload\UploadInterface');

        $user = App\Riiingme\User\Entities\User::find(1);
        $this->be($user);

        VfsStream::setup('users');

    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testAssignPhotoUser()
    {
        /*
                $filename = 'test.jpg';

                $file = new \Symfony\Component\HttpFoundation\File\UploadedFile( base_path() . '/tests/Files/'.$filename, $filename );

                $expect = (string) \Image::make( base_path() . '/tests/Files/'.$filename )->encode('data-url');

                $response = $this->call('POST', 'upload', [] ,[], ['file' => [$file]]);

                $this->assertTrue($response->isOk());

               $user_id = 1;
                $id      = 1;
                $label   = 'test.jpg';

                $this->mock->shouldReceive('updatePhoto')->with($user_id,$label,$id)->once();

                $path     = dirname(dirname(dirname(dirname(__FILE__)))) . '/test/'; ;
                $filename = 'test.jpg';;

                $file = new \Symfony\Component\HttpFoundation\File\UploadedFile (
                    $path.$filename, $filename, 'image/jpeg', '351106'
                );
                //$response = $this->call('POST', 'upload', [] ,[], ['file' => [$file]]);
                //$this->mock->shouldReceive('upload')->with($file)->once()->andReturn(['name' => $filename ,'ext' => '.jpg' ,'mime' => 'image/jpeg' ,'path' => base_path() . '/tests/Files/'.$filename ]);

                $response = $this->call('POST', 'upload', [ 'user_id'  => 1 , '_token' => csrf_token() , 'photo' => 'avatar.jpg', 'label_id' => 1 ] ,[], ['file' => $file]);

                //call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)

                echo '<pre>';
                print_r($response->getContent());
                echo '</pre>';exit;

                $this->assertTrue($response->isOk());
        */
    }

}
