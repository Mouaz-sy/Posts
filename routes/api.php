<?php

use Illuminate\Http\Request;
use App\Models\FavoretUsersPoste;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoretUsersPosteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::apiResource('/posts', PostController::class)->middleware('auth:sanctum');

Route::get('/users_role',[UserController::class,'AllRole'])->middleware('auth:sanctum')->middleware('is_admin');

Route::apiResource('/favoret',FavoretUsersPosteController::class)->middleware('auth:sanctum');

Route::apiResource('profile',ProfileController::class);
//->middleware('auth.sanctum');