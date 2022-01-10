<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Chair;
use Illuminate\Support\Facades\DB;

class   UniversityController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page') ?: 1;
        $query = $request->input('searchField') ? explode(',', $request->input('searchField')) : false;
        $count = 10;
        $filter = '';
        if ($query) {
            $filter = '&searchField=';
            $filterParams = '';
            $getStudent =  University::query();
            foreach ($query as $column) {
                if ($value = $request->input($column)) {
                    $filter .= $column . ',';
                    $filterParams .= "&" . $column . "=" . $value;
                    $getStudent->where($column, 'like',
                        (stripos($column, '_id')) ? $value :'%'.$value.'%');
                }
            }
            $filter = trim($filter, ',') . $filterParams;
            $allCount = $getStudent->count(['id']);
            $data["universities"] = $getStudent->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["universities"] = University::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = University::query()->count(['id']);
        }

        foreach ($data["universities"] as &$university) {
            $university["chairs"] = University::find($university["id"])->chairs()->get()->toArray();
        }
        $data["chairs"] =  Chair::all()->sortBy('id')->toArray();

        return view("university", [
            "Universities" => $data["universities"],
            "chairs" => $data["chairs"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "University",
            "filter" => $filter,
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
            "address" => $data["address"]
        ];
        $changeElem = University::query()->where("id",$data["id"])->update($update);
        $changeLink = University::find($data["id"])->chairs()->sync($data["chairs"]);
        if ($changeElem || $changeLink) {
            $result = University::query()->where("id",$data["id"])->get()->toArray();
            $result["chairs"] = University::find($data["id"])->chairs()->get()->toArray();
        } else {
            $result = ["error"=>"Ошибка изменения базы."];
        }
        return \response(json_encode($result));
    }

    public function delete(Request $request)
    {
        $deleteId = $request->toArray();
        $deleted = true;
        foreach ($deleteId as $id) {
            DB::table("chair_university")->where("university_id","=",$id)->delete();
            if(!University::find($id)->delete()) {
                $deleted = false;
                break;
            }
        }
        if ($deleted) {
            $res = [
                "message" => "Selected element was terminated",
                "status" => "ok"
                ];
        } else {
            $res = [
                "message" => "Error in query.",
                "status" => "error"
            ];
        }
        return \response(json_encode($res));
    }

    public function add(Request $request)
    {
        $data = $request->toArray();
        $newData = [
            "name" => $data["name"],
            "address" => $data["address"]
        ];
        if (University::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой университет уже существует"
            ]));
        }
        if ($newElem = University::firstOrCreate($newData)) {
            University::find($newElem["id"])->chairs()->sync($data["chairs"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
