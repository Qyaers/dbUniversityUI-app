<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
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
            $getQuery =  Student::query();
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
            $data["students"] = $getQuery->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["students"] = Student::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = Student::query()->count(['id']);
        }

        foreach ($data["students"] as &$student) {
            $student["group"] = Student::find($student["id"])->group()->get()->toArray();
        }
        $data["groups"] =  Group::all()->sortBy('id')->toArray();

        return view("students", [
            "students" => $data["students"],
            "groups" => $data["groups"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "Student",
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
            'role' => $data["role"][0],
            "group_id" => $data["group"][0]
        ];
        $changeElem = Student::query()->where("id",$data["id"])->update($update);
        if ($changeElem) {
            $result = Student::query()->where("id",$data["id"])->get()->toArray();
            $result["group"] = Student::find($data["id"])->group()->get()->toArray();
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
            if(Student::find($id)->delete()) {
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
            'role' => $data["role"][0],
            "group_id" => $data["group"][0]
        ];
        if ($newElem = Student::firstOrCreate($newData)) {
//            Student::find($newElem["id"])->group()->sync($data["group"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
