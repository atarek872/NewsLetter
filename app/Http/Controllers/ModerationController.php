<?php

namespace App\Http\Controllers;

use App\Lib\FileManagment;
use App\Models\LOBS;
use App\Models\News;
use Illuminate\Http\Request;
use App\Repositories\LOBsRepo;
use App\Repositories\NewsRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ModerationController extends Controller
{
    public function HomeRender(){
        $LOBs = LOBS::all()->toArray();
        return view('Moderation.Home')->with([
            'LOBs'=>$LOBs
        ]);
    }

    public function NewsRender($id){
        $existCheck = LOBS::where('id',$id)->get()->count();
        if ($existCheck > 0){
            $ListNews = News::where('Lob_id',$id)->get()->toArray();
            return view('Moderation.PageNews')->with([
                'ListNews'=>$ListNews
            ]);
        }else{
            return 'Some thing went wrong';
        }
    }

    public function RenderOnePost($id,$lob_id){
//        dd($lob_id);
        $existCheck = News::where(['id'=>$id , 'Lob_id'=>$lob_id])->get()->count();
        if ($existCheck > 0){
            $OnePost = News::where(['id'=>$id , 'Lob_id'=>$lob_id])->get()->toArray();
            return view('Moderation.OnePost')->with([
                'OnePost'=>$OnePost
            ]);
        }else{
            return 'Some thing went wrong';
        }
    }

    public function CreateLOBRender(){

        $LOBS = LOBS::all()->toArray();
        return view('Moderation.CreateLOB')->with([
            'LOBS'=>$LOBS
        ]);

    }

    public function CreateLOBAction(Request $request){

        $data= array();
        $data[] = [
            'Lob_name' => $request->name,
            'Description' => $request->Description,
        ];
        $checkBefore =  LOBsRepo::CheckIssetBefore($request->name);
//        dd($checkBefore =0);
        if ($checkBefore == 0){
            $save =  LOBsRepo::CreateNew($data);
            $LOBData = LOBS::where('Lob_name',$request->name)->get()->toArray();
            if ($save == true){
                return response()->json(['success'=>'Data is successfully added','name' =>$LOBData[0]['Lob_name'],'id' =>$LOBData[0]['id']]);

            }else{
                return response()->json(['success'=>'Sorry something went wrong']);
            }
        }else{
            return response()->json(['success'=>'Sorry This LOB Name exist already before']);
        }

    }

    public function EditLOB(Request $request){
        $data= array();
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        $data[] = [
            'name' => $request->name,
            'Description' =>$request->Description,
            'imageName' =>$imageName,
            'id' =>$request->ID
        ];
        $update = LOBsRepo::UpdateLOB($data);

        if ($update == true){
            session()->flash('success','your LOB has been Updated Successfully');
            return redirect()->back();
        }else{
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }

    }

    public function DeleteLOB(Request $request){
        $data= array();
        $data[] = [
            'id' =>$request->ID
        ];
        $Update =  LOBsRepo::DeleteLOB($data);
        if ($Update == true){
            session()->flash('success','your LOB has been Deleted Successfully');
            return redirect()->back();
        }else{
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }

    }

    public function CreateNewsRender($id){

            $lob = LOBS::where('id',$id)->get()->count();
            $LOBSName = LOBS::where('id',$id)->get()->toArray();
            $Posts = News::where('Lob_id',$id)->get()->toArray();
            if ($lob == 0){
                echo 'Lob Not Exist :) ';
            }else{
                return view('Moderation.AddNews')->with([
                    'LOBSName'=>$LOBSName,
                    'Posts'=>$Posts
                ]);
            }
    }
    public function CreateNewsAction(Request $request,$id){
        $data= array();

        $data[] = [
            'Header' => $request->name,
            'body' => $request->body,
            'Lob_id' => $id,
        ];

        $save =  NewsRepo::CreateNews($data);
        $latest_post = News::select('id')->orderBy('created_at', 'desc')->first();
        $NewPostData = News::where('id',$latest_post->id)->get()->toArray();
        if ($save == true){
            return response()->json(['success'=>'Data is successfully added',
                'id'=>$NewPostData[0]['id'],
                'Header' => $NewPostData[0]['Header'],
                'body'=>$NewPostData[0]['body'],
                'created_at'=>$NewPostData[0]['created_at'],
                'updated_at'=>$NewPostData[0]['updated_at']]);

        }else{
            return response()->json(['success'=>'Sorry something went wrong']);
        }
    }

    public function UpdatePost(Request $request){
        $data= array();
        $data[] = [
            'title' => $request->title,
            'Body' =>$request->Body,
            'id_post' =>$request->id_post
        ];
        $Update =  NewsRepo::UpdatePost($data);

        if ($Update == true){
            session()->flash('success','your post has been updated Successfully');
            return redirect()->back();
        }else{
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }

    }

    public function DeletePost(Request $request){
        $data= array();
        $data[] = [
            'id_post' =>$request->id_post
        ];
        $Update =  NewsRepo::DeletePost($data);
        if ($Update == true){
            session()->flash('success','your post has been Deleted Successfully');
            return redirect()->back();
        }else{
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }

    }
}
