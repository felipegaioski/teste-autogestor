<?php

namespace App\Http\Controllers;

use App\Models\AccessLevel;
use Illuminate\Http\Request;

class AccessLevelController extends Controller
{
    public function get() {
        $user = auth()->user()->load('access_level');
        $access_levels = AccessLevel::all()->load('users');
        return view('site.access-levels.index', compact('user', 'access_levels'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
    }
}
