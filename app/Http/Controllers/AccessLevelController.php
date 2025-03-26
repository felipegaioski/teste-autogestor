<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessLevelController extends Controller
{
    public function get() {

    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        info($request->toArray());
    }
}
