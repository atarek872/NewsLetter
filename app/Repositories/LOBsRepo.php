<?php namespace App\Repositories;


use App\Models\LOBS;
use Carbon\Carbon;
class LOBsRepo  {

//    private static $instance;
//    public static function getInstance()
//    {
//        if (null === static::$instance) {
//            static::$instance = new static();
//        }
//
//        return static::$instance;
//    }

    public static function CreateNew($data)
    {
        $Create = new LOBS;
        $Create->Lob_name = $data[0]['Lob_name'];
        $Create->Description = $data[0]['Description'];
        $Create->Image = null;
        $Create->created_at = Carbon::now();
        $Create->updated_at = Carbon::now();
        $status = (boolean) $Create->save();

        return $status;
    }

    public static function CheckIssetBefore($name){
        $before = LOBS::where('Lob_name',$name)->get()->count();
        return $before;
    }

    public static function UpdateLOB($data){
//        dd($data);
        $Update = (boolean) LOBS::where('id',$data[0]['id'])->update([
            'Lob_name' => $data[0]['name'],
            'Description' => $data[0]['Description'],
            'Image' => $data[0]['imageName'],
            'updated_at' => Carbon::now()
        ]);

        return $Update;
    }

    public static function DeleteLOB($data){

        $Update = (boolean) LOBS::where('id',$data[0]['id'])->delete();

        return $Update;
    }




}
