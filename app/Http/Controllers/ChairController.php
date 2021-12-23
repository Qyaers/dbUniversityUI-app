<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\University;
use Illuminate\Http\Request;

class ChairController extends Controller
{
    public function index(Request $request)
    {
        $data["chairs"] = Chair::all()->sortBy("id")->toArray();
        foreach ($data["chairs"] as &$chair) {
            $chair["universities"] = Chair::find($chair["id"])->universities()->get()->toArray();
        }
        $data["universities"] =  University::all()->sortBy('id')->toArray();
        /*        echo "<pre>";
                print_r($data);*/
        return view("chairs", [
            "chairs" => $data["chairs"],
            "universities" => $data["universities"]
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
        ];
        $changeElem = Chair::find($data['id'])->update($update);
        $changeLink = Chair::find($data["id"])->universities()->sync($data["university"]);
        if ($changeElem || $changeLink) {
            $result = Chair::find($data["id"])->get()->toArray();
            $result["universities"] = Chair::find($data["id"])->universities()->get()->toArray();
        } else {
            $result = ["error"=>"Ошибка изменения базы."];
        }
        return \response(json_encode($result));
    }

    public function add(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}
