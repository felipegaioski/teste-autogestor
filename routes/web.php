<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccessLevelController;

// Route::get('/', function () { return view('site.home'); });
Route::get('/', [Controller::class, 'get'] );

//users
Route::get('/usuarios', [UserController::class, 'get']);
Route::get('/usuarios/novo', [UserController::class, 'createPage']);
Route::post('/usuarios/novo', [UserController::class, 'store']);
Route::post('/usuarios/login', [UserController::class, 'login']);
Route::post('/usuarios/logout', [UserController::class, 'logout']);

//access-levels
Route::get('/niveis-de-acesso', [AccessLevelController::class, 'get']);
Route::get('/niveis-de-acesso/novo', function () { return view('site.access-levels.create'); });
Route::post('/niveis-de-acesso/novo', [AccessLevelController::class, 'store']);
Route::get('/niveis-de-acesso/{id}/editar', [AccessLevelController::class, 'edit']);
Route::post('/niveis-de-acesso/{id}/editar', [AccessLevelController::class, 'update']);

Route::get('new-permission-category/{category_name}/{category_type}/{unique_permission?}/{unique_name?}', [AccessLevelController::class, 'new_permission_category']);

