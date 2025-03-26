<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccessLevelController;

Route::get('/', function () { return view('site.home'); });
Route::get('/niveis-de-acesso', function () { return view('site.access-levels.index'); });
Route::get('/niveis-de-acesso/novo', function () { return view('site.access-levels.create'); });
Route::post('/niveis-de-acesso/novo', [AccessLevelController::class, 'store']);
Route::get('/usuarios', [UserController::class, 'get']);

// Route::get('/', function () { return view('welcome'); });