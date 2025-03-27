<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function get() 
    { 
        if (auth()->check()) {
            $user = auth()->user()->load('access_level');
            return view('site.home', compact('user'));
        } else {
            return app(UserController::class)->loginPage();
        }
    }
}
