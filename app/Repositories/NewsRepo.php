<?php namespace App\Repositories;


use App\Models\News;
use Carbon\Carbon;
class NewsRepo{

    public static function CreateNews($data)
    {
        $Create = new News;
        $Create->Header = $data[0]['Header'];
        $Create->body = $data[0]['body'];
        $Create->Lob_id = $data[0]['Lob_id'];
        $Create->created_at = Carbon::now();
        $Create->updated_at = Carbon::now();
        $status = (boolean) $Create->save();

        return $status;
    }


    public static function UpdatePost($data){
        $update = (boolean) News::where('id',$data[0]['id_post'])->update([
            'Header'=>$data[0]['title'],
            'body'=>$data[0]['Body'],
            'updated_at'=>Carbon::now()
        ]);
        return $update;
    }

    public static function DeletePost($data){
        $update = (boolean) News::where('id',$data[0]['id_post'])->delete();
        return $update;
    }


}
