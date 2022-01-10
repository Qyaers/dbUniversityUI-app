<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/dbEditor/University",[\App\Http\Controllers\UniversityController::class,'index']);
Route::get("/dbEditor/Chair",[\App\Http\Controllers\ChairController::class,'index']);
Route::get("/dbEditor/Subject",[\App\Http\Controllers\SubjectController::class,'index']);
Route::get("/dbEditor/Student",[\App\Http\Controllers\StudentController::class,'index']);
Route::get("/dbEditor/Program",[\App\Http\Controllers\ProgramController::class,'index']);
Route::get("/dbEditor/Group",[\App\Http\Controllers\GroupController::class,'index']);
Route::get("/dbEditor/Faculty",[\App\Http\Controllers\FacultyController::class,'index']);
Route::get("/dbEditor/Course",[\App\Http\Controllers\CourseController::class,'index']);
Route::get("/dbEditor/Lecturer",[\App\Http\Controllers\LecturerController::class,'index']);

Route::group(['middleware' => ['web']], function () {
    Route::post("/dbEditor/University/edit",[\App\Http\Controllers\UniversityController::class,'edit']);
    Route::post("/dbEditor/University/delete",[\App\Http\Controllers\UniversityController::class,'delete']);
    Route::post("/dbEditor/University/add",[\App\Http\Controllers\UniversityController::class,'add']);

    Route::post("/dbEditor/Subject/edit",[\App\Http\Controllers\SubjectController::class,'edit']);
    Route::post("/dbEditor/Subject/delete",[\App\Http\Controllers\SubjectController::class,'delete']);
    Route::post("/dbEditor/Subject/add",[\App\Http\Controllers\SubjectController::class,'add']);

    Route::post("/dbEditor/Student/edit",[\App\Http\Controllers\StudentController::class,'edit']);
    Route::post("/dbEditor/Student/delete",[\App\Http\Controllers\StudentController::class,'delete']);
    Route::post("/dbEditor/Student/add",[\App\Http\Controllers\StudentController::class,'add']);

    Route::post("/dbEditor/Chair/edit",[\App\Http\Controllers\ChairController::class,'edit']);
    Route::post("/dbEditor/Chair/delete",[\App\Http\Controllers\ChairController::class,'delete']);
    Route::post("/dbEditor/Chair/add",[\App\Http\Controllers\ChairController::class,'add']);

    Route::post("/dbEditor/Program/edit",[\App\Http\Controllers\ProgramController::class,'edit']);
    Route::post("/dbEditor/Program/delete",[\App\Http\Controllers\ProgramController::class,'delete']);
    Route::post("/dbEditor/Program/add",[\App\Http\Controllers\ProgramController::class,'add']);

    Route::post("/dbEditor/Group/edit",[\App\Http\Controllers\GroupController::class,'edit']);
    Route::post("/dbEditor/Group/delete",[\App\Http\Controllers\GroupController::class,'delete']);
    Route::post("/dbEditor/Group/add",[\App\Http\Controllers\GroupController::class,'add']);

    Route::post("/dbEditor/Faculty/edit",[\App\Http\Controllers\FacultyController::class,'edit']);
    Route::post("/dbEditor/Faculty/delete",[\App\Http\Controllers\FacultyController::class,'delete']);
    Route::post("/dbEditor/Faculty/add",[\App\Http\Controllers\FacultyController::class,'add']);

    Route::post("/dbEditor/Course/edit",[\App\Http\Controllers\CourseController::class,'edit']);
    Route::post("/dbEditor/Course/delete",[\App\Http\Controllers\CourseController::class,'delete']);
    Route::post("/dbEditor/Course/add",[\App\Http\Controllers\CourseController::class,'add']);

    Route::post("/dbEditor/Lecturer/edit",[\App\Http\Controllers\LecturerController::class,'edit']);
    Route::post("/dbEditor/Lecturer/delete",[\App\Http\Controllers\LecturerController::class,'delete']);
    Route::post("/dbEditor/Lecturer/add",[\App\Http\Controllers\LecturerController::class,'add']);
});

