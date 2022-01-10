<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Program;
use App\Models\Subject;
use Illuminate\Http\Request;

class ProgramController extends Controller
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
            $getStudent =  Program::query();
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
            $data["programs"] = $getStudent->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["programs"] = Program::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = Program::query()->count(['id']);
        }
        foreach ($data["programs"] as &$program) {
            $program["courses"] = Program::find($program["id"])->course()->get()->toArray();
            $program["subjects"] = Program::find($program["id"])->subject()->get()->toArray();
            $program["lecturers"] = Program::find($program["id"])->lecturer()->get()->toArray();
        }
        $data["courses"] =  Course::all()->sortBy('id')->toArray();
        $data["subjects"] =  Subject::all()->sortBy('id')->toArray();
        $data["lecturers"] =  Lecturer::all()->sortBy('id')->toArray();

        return view("program", [
            "programs" => $data["programs"],
            "courses" => $data["courses"],
            "subjects" => $data["subjects"],
            "lecturers" => $data["lecturers"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "Program",
            "filter" => $filter,

        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "hours" => $data["hours"],
            "course_id" => $data["courses"][0],
            "subject_id" => $data["subjects"][0],
            "lecturer_id" => $data["lecturers"][0]
        ];
        $changeElem = Program::query()->where("id",$data["id"])->update($update);
        if ($changeElem) {
            $result = Program::query()->where("id",$data["id"])->get()->toArray();
            $result["course"] = Program::find($data["id"])->course()->get()->toArray();
            $result["subject"] = Program::find($data["id"])->subject()->get()->toArray();
            $result["lecturer"] = Program::find($data["id"])->lecturer()->get()->toArray();
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
            if(Program::find($id)->delete()) {
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
            "hours" => $data["hours"],
            "course_id" => $data["courses"][0],
            "subject_id" => $data["subjects"][0],
            "lecturer_id" => $data["lecturers"][0]
        ];
        if (Program::query()->where([["course_id","=",$newData["course_id"]],["subject_id","=",$newData["subject_id"]],["lecturer_id","=",$newData["lecturer_id"]]])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой программа уже существует"
            ]));
        }
//        return \response(json_encode([
//            "status" => "error",
//            "data" => $newData,
//        ]));

        if ($newElem = Program::firstOrCreate($newData)) {
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
