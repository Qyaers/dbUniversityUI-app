<?php

namespace App\Http\Controllers;

use App\Models\Chair;
use App\Models\Course;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Program;
use App\Models\University;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page') ?: 1;
        $count = 10;
        $data["courses"] = Course::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();

        foreach ($data["courses"] as &$course) {
            $course["universities"] = Course::find($course["id"])->university()->get()->toArray();
            if($course["universities"])
                $course["universityChairs"] = University::find($course["universities"][0]["id"])->chairs()->get()->pluck("id")->toArray();
            $course["chair"] = Course::find($course["id"])->chair()->get()->toArray();
            $course["groups"] = Course::find($course["id"])->groups()->get()->toArray();
            $course["programs"] = Subject::findMany(Course::find($course["id"])->programs()->get()->pluck("subject_id")->toArray())->toArray();
        }
        $data["universities"] =  University::all()->sortBy('id')->toArray();
        $data["chairs"] =  Chair::all()->sortBy('id')->toArray();
        $data["groups"] =  Group::all()->sortBy('id')->toArray();
        $data["programs"] =  Program::all()->sortBy('id')->toArray();

        return view("course", [
            "courses" => $data["courses"],
            "chairs" => $data["chairs"],
            "universities" => $data["universities"],
            "groups" => $data["groups"],
            "programs" => $data["programs"],
            "count_page" => ceil(Course::query()->count(['id']) / $count),
            "cur_page" => $page,
            "page_name" => "Course",
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
            "number" => $data["number"],
            "chair_id" => $data["chair"][0],
        ];
        $changeElem = Course::query()->where("id",$data["id"])->update($update);
        if ($changeElem) {
            $result = Course::query()->where("id",$data["id"])->get()->toArray();

        } else {
            $result = ["error"=>"Ошибка изменения базы."];
        }
        return \response(json_encode($result));
    }
// TODO Не работает delete(не доделано)
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
            "university_id" => $data["universities"][0],
            "chair_id" => $data["chair"][0],
        ];
        if (Course::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой предмет уже существует"
            ]));
        }
        if ($newElem = Course::firstOrCreate($newData)) {
//            Group::find($newElem["id"])->course()->sync($data["courses"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
