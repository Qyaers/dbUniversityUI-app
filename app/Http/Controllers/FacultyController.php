<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Chair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
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
            $getQuery =  Faculty::query();
            foreach ($query as $column) {
                if ($value = $request->input($column)) {
                    $filter .= $column . ',';
                    $filterParams .= "&" . $column . "=" . $value;
                    $getQuery->where($column, 'like',
                        (stripos($column, '_id')) ? $value :'%'.$value.'%');
                }
            }
            $filter = trim($filter, ',') . $filterParams;
            $allCount = $getQuery->count(['id']);
            $data["faculties"] = $getQuery->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["faculties"] = Faculty::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = Faculty::query()->count(['id']);
        }
        foreach ($data["faculties"] as &$faculty) {
            $faculty["chairs"] = Faculty::find($faculty["id"])->chairs()->get()->toArray();
        }
        $data["chairs"] =  Chair::all()->sortBy('id')->toArray();

        return view("faculty", [
            "faculties" => $data["faculties"],
            "chairs" => $data["chairs"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "Faculty",
            "filter" => $filter,
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
        ];
        $changeElem = Faculty::query()->where("id",$data["id"])->update($update);
        if ($changeElem) {
            $result = Faculty::query()->where("id",$data["id"])->get()->toArray();
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
            if(Faculty::find($id)->delete()) {
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
        ];
        if (Faculty::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой предмет уже существует"
            ]));
        }
        if ($newElem = Faculty::firstOrCreate($newData)) {

            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
