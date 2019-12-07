<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grocery;
class GroceryController extends Controller
{
    public function Render(){
        return view('grocery');
    }

    public function store(Request $request)
    {
        $grocery = new Grocery();
        $grocery->name = $request->name;
        $grocery->type = $request->type;
        $grocery->price = $request->price;

        $grocery->save();
        return response()->json(['success'=>'Data is successfully added by' .$request->name]);
    }
}
