<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
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
            $getStudent =  Lecturer::query();
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
            $data["lecturers"] = $getStudent->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["lecturers"] = Lecturer::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = Lecturer::query()->count(['id']);
        }
        foreach ($data["lecturers"] as &$lecturer) {
            $lecturer["university"] = Lecturer::find($lecturer["id"])->university()->get()->toArray();
            $lecturer["subjects"] = Lecturer::find($lecturer["id"])->subjects()->get()->toArray();
        }
        $data["universities"] =  University::all()->sortBy('id')->toArray();
        $data["subjects"] =  Subject::all()->sortBy('id')->toArray();

        return view("lecturer", [
            "lecturers" => $data["lecturers"],
            "universities" => $data["universities"],
            "subjects" => $data["subjects"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "Lecturer",
            "filter" => $filter,
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            'firstName' => $data["firstName"],
            'name' => $data["name"],
            'secondName' => $data["secondName"],
            'position' => $data["position"],
            "university_id" => $data["university"][0]
        ];
        $changeElem = Lecturer::query()->where("id",$data["id"])->update($update);
        $changeLink = Lecturer::find($data["id"])->subjects()->sync($data["subjects"]);
        if ($changeElem || $changeLink) {
            $result = Lecturer::query()->where("id",$data["id"])->get()->toArray();
            $result["university"] = Lecturer::find($data["id"])->university()->get()->toArray();
            $result["subjects"] = Lecturer::find($data["id"])->subjects()->get()->toArray();
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
            DB::table("lecturer_subject")->where("lecturer_id","=",$id)->delete();
            if(Lecturer::find($id)->delete()) {
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
            'firstName' => $data["firstName"],
            'name' => $data["name"],
            'secondName' => $data["secondName"],
            'position' => $data["position"],
            "university_id" => $data["university"][0]
        ];
        if ($newElem = Lecturer::firstOrCreate($newData)) {
            if(isset($data["subject"]))
                Lecturer::find($newElem["id"])->subjects()->sync($data["subject"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
