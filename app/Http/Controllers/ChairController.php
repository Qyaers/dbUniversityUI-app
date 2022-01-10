<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\Faculty;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChairController extends Controller
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
            $getQuery =  Chair::query();
            foreach ($query as $column) {
                if ($value = $request->input($column)) {
                    $filter .= $column . ',';
                    $filterParams .= "&" . $column . "=" . $value;
                    if ($column == 'university_id') {
                        $getQuery->join('chair_university','chair_university.chair_id','=', 'chairs.id')
                            ->where('chair_university.university_id','like', $value);
                    } else {
                        $getQuery->where($column, 'like',
                            (stripos($column, '_id')) ? $value : '%' . $value . '%');
                    }
                }
            }
            $filter = trim($filter, ',') . $filterParams;
            $allCount = $getQuery->count(['id']);
            $data["chairs"] = $getQuery->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["chairs"] = Chair::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = Chair::query()->count(['id']);
        }

        foreach ($data["chairs"] as &$chair) {
            $chair["universities"] = Chair::find($chair["id"])->universities()->get()->toArray();
            $chair["faculties"] = Chair::find($chair["id"])->faculty()->get()->toArray();
        }
        $data["universities"] =  University::all()->sortBy('id')->toArray();
        $data["faculties"] =  Faculty::all()->sortBy('id')->toArray();

        return view("chairs", [
            "chairs" => $data["chairs"],
            "universities" => $data["universities"],
            "faculties" => $data["faculties"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "Chair",
            "filter" => $filter,
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
            "faculty_id" => $data["faculties"][0]
        ];
        $changeElem = Chair::query()->where("id",$data["id"])->update($update);

        if ($changeElem) {
            $result = Chair::query()->where("id",$data["id"])->get()->toArray();
            $result["universities"] = Chair::find($data["id"])->universities()->get()->toArray();
            $result["faculties"] = Chair::find($data["id"])->faculty()->get()->toArray();
        } else {
            $result = ["error"=>"Ошибка изменения базы."];
        }
        return \response(json_encode($result));
    }

    public function delete(Request $request)
    {
        $deleteId = $request->toArray();
        $deleted = $error = false;
        foreach ($deleteId as $id) {
            DB::table("chair_university")->where("chair_id","=",$id)->delete();
            if(Chair::find($id)->delete()) {
                $deleted = true;
            } else {
                $error = true;
                break;
            }
        }
        if ($deleted && !$error) {
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
            "faculty_id" => $data["faculties"][0]
        ];
        if (Chair::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой предмет уже существует"
            ]));
        }
        if ($newElem = Chair::firstOrCreate($newData)) {
            Chair::find($newElem["id"])->universities()->sync($data["universities"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
