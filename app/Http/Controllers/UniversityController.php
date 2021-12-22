<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $data = University::all()->toArray();
/*        echo "<pre>";
        print_r($data);*/
        return view("university",["Universities"=>$data]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        /*$result = University::query()->where("id",$data["id"])->update($data);*/
        return \response(json_encode($data));
    }
}
