<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/get-projects',[ProjectController::class,'index']);
Route::post('/create-projects',[ProjectController::class,'create']);
Route::post('/store-projects',[ProjectController::class,'store']);
Route::get('/destroy-projects/{id}',[ProjectController::class,'destroy']);
