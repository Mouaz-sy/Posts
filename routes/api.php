<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\CommentsPostController;
use Illuminate\Http\Request;
use App\Models\FavoretUsersPoste;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoretUsersPosteController;

Route::get('/user',[UserController::class,'userInfo'])->middleware('auth:sanctum');

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::apiResource('/posts', PostController::class)->middleware('auth:sanctum');

Route::get('/users_role',[UserController::class,'AllRole'])->middleware('auth:sanctum')->middleware('is_admin');

Route::apiResource('/favoret',FavoretUsersPosteController::class)->middleware('auth:sanctum');

Route::apiResource('/profile',ProfileController::class)->middleware('auth:sanctum');

Route::apiResource('/categories',CategoryController::class)->middleware('auth:sanctum');

// مسارات لإدارة العلاقات بين المنشورات والفئات
Route::get('posts/{post}/categories', [CategoryPostController::class, 'indexForPost']);
Route::post('posts/{post}/categories', [CategoryPostController::class, 'attachCategories']);
Route::delete('posts/{post}/categories/{category}', [CategoryPostController::class, 'detachCategory']);

Route::apiResource('posts.comments',CommentsPostController::class)->middleware('auth:sanctum');