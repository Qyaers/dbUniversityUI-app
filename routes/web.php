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
});

