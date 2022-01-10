<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page') ?: 1;
        $count = 10;
        $data["subjects"] = Subject::query()->orderBy('id')->offset($count * ($page-1))->limit($count)->get()->toArray();

        foreach ($data["subjects"] as &$subject) {
            $subject["lecturers"] = Subject::find($subject["id"])->lecturers()->get()->toArray();
        }
        $data["lecturers"] =  Lecturer::all()->sortBy('id')->toArray();

        return view("subject", [
            "subjects" => $data["subjects"],
            "lecturers" => $data["lecturers"],
            "count_page" => ceil(Subject::query()->count(['id']) / $count),
            "cur_page" => $page,
            "page_name" => "Subject",
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();
        $update = [
            "name" => $data["name"],
        ];
        $changeElem = Subject::query()->where("id",$data["id"])->update($update);
        $changeLink = Subject::find($data["id"])->lecturers()->sync($data["lecturers"]);
        if ($changeElem || $changeLink) {
            $result = Subject::query()->where("id",$data["id"])->get()->toArray();
            $result["lecturers"] = Subject::find($data["id"])->lecturers()->get()->toArray();
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
            DB::table("lecturer_subject")->where("subject_id","=",$id)->delete();
            DB::table("programs")->where("subject_id","=",$id)->delete();
            DB::table("subject_university")->where("subject_id","=",$id)->delete();
            if(Subject::find($id)->delete()) {
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
        if (Subject::query()->where("name","=",$newData["name"])->get()->count()) {
            return \response(json_encode([
                "status" => "error",
                "message" => "Такой предмет уже существует"
            ]));
        }
        if ($newElem = Subject::firstOrCreate($newData)) {
            Subject::find($newElem["id"])->lecturers()->sync($data["lecturers"]);
            return \response(json_encode($newElem));
        }
        else{

        }
    }
}
