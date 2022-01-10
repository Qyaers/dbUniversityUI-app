<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\Course;
use App\Models\Group;
use App\Models\Stream;
use App\Models\Subject;
use App\Models\Program;
use App\Models\University;
use Illuminate\Http\Request;

class CourseController extends Controller
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
            $getStudent =  Course::query();
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
            $data["courses"] = $getStudent->orderBy('id')
                ->offset($count * ($page-1))->limit($count)->get()->toArray();
        } else {
            $data["courses"] = Course::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();
            $allCount = Course::query()->count(['id']);
        }
        foreach ($data["courses"] as &$course) {
            $stream = Stream::query()->where("course_id", "=", $course["id"])->get()->toArray()[0];
            if (isset($stream["university_id"])){
                $course["university"] = University::find($stream["university_id"])->toArray();
                $course["universityChairs"] = University::find($stream["university_id"])->chairs()->get()->pluck("id")->toArray();
            }
            if (isset($stream["chair_id"]))
                $course["chair"] = Chair::find($stream["chair_id"])->toArray();
            $course["groups"] = Course::find($course["id"])->groups()->get()->toArray();
            $course["programs"] = Subject::findMany(Course::find($course["id"])->programs()->get()->pluck("subject_id")->toArray())->toArray();
        }
        $data["universities"] =  University::all()->sortBy('id')->toArray();
        foreach ($data["universities"] as &$university) {
            $university["chairs"] = University::find($university["id"])->chairs()->get()->pluck("id")->toArray();
        }
        $data["chairs"] =  Chair::all()->sortBy('id')->toArray();
        $data["groups"] =  Group::all()->sortBy('id')->toArray();
        $data["programs"] =  Program::all()->sortBy('id')->toArray();

        return view("course", [
            "courses" => $data["courses"],
            "chairs" => $data["chairs"],
            "universities" => $data["universities"],
            "groups" => $data["groups"],
            "programs" => $data["programs"],
            "count_page" => ceil($allCount / $count),
            "cur_page" => $page,
            "page_name" => "Course",
            "filter" => $filter,
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
            "number" => $data["number"],
        ];
        if ($data["name"] || $data["number"]) {
            $changeElem = Course::query()->where("id",$data["id"])->update($update);
        }
        if ($data["chair"][0]) {
            $changeElem = Stream::query()->where("course_id","=",$data["id"])->update([
                "chair_id" => $data["chair"][0]
            ]);
        }
        if ($changeElem) {
            $result = Course::query()->where("id",$data["id"])->get()->toArray();

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
            if(Course::find($id)->delete()) {
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
            "number" => $data["number"],
        ];
        if (Course::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой предмет уже существует"
            ]));
        }
        if ($newElem = Course::firstOrCreate($newData)) {
            $newData = [
                "university_id" =>$data["university"][0],
                "chair_id" =>$data["chair"][0],
                "course_id" =>$newElem["id"],
            ];
            Stream::firstOrCreate($newData);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
