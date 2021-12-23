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
Route::group(['middleware' => ['web']], function () {
    Route::post("/dbEditor/University/edit",[\App\Http\Controllers\UniversityController::class,'edit']);
    Route::post("/dbEditor/University/delete",[\App\Http\Controllers\UniversityController::class,'delete']);
    Route::post("/dbEditor/University/add",[\App\Http\Controllers\UniversityController::class,'add']);
    Route::post("/dbEditor/Chair/edit",[\App\Http\Controllers\ChairController::class,'edit']);
});

