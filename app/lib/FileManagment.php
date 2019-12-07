<?php


namespace App\lib;

use  File ;

class FileManagment
{
    private static $instance;
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    public  function uploadFile($file,$name,$directoryName)
    {
        if($this->directoryIfExist($directoryName))
        {
            $file = $file->file($name);
            $fileName =  str_random(6).time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/'. $directoryName , $fileName);
            return ['extension' => $file->getClientOriginalExtension() , 'fileName' => $fileName , 'originalName' => $file->getClientOriginalName()] ;
        }
        return false ;
    }
    private function directoryIfExist($directoryName)
    {
        $path = public_path().'/'. $directoryName;
        if(File::isDirectory($path))
        {
            return true ;
        }
        File::makeDirectory($path, 0777, true, true);
        return true ;
    }
    public function updateImage($file, $name, $directoryName, $oldFileName)
    {
        File::delete($oldFileName);
        return $this->uploadFile($file,$name,$directoryName);
    }
    public function  uploadFiles($file,$name,$directoryName)
    {
        if($this->directoryIfExist($directoryName))
        {
//            $file = $file->file($name);
            $fileName =  str_random(6).time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/'. $directoryName , $fileName);
            return $fileName ;
        }
        return false ;
    }
}
