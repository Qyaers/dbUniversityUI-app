<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Course;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page') ?: 1;
        $count = 40;
        $data["groups"] = Group::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();

        foreach ($data["groups"] as &$group) {
            $group["courses"] = Group::find($group["id"])->course()->get()->toArray();
        }
        $data["courses"] =  Course::all()->sortBy('id')->toArray();

        return view("group", [
            "groups" => $data["groups"],
            "courses" => $data["courses"],
            "count_page" => ceil(Group::query()->count(['id']) / $count),
            "cur_page" => $page,
            "page_name" => "Group",
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
            "course_id" => $data["courses"][0],
        ];
        $changeElem = Group::query()->where("id",$data["id"])->update($update);
        if ($changeElem) {
            $result = Group::query()->where("id",$data["id"])->get()->toArray();
            $result["course"] = Group::find($data["id"])->course()->get()->toArray();
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
            if(Group::find($id)->delete()) {
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
            "course_id" => $data["courses"][0],
        ];
        if (Group::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой предмет уже существует"
            ]));
        }
        if ($newElem = Group::firstOrCreate($newData)) {
//            Group::find($newElem["id"])->course()->sync($data["courses"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
