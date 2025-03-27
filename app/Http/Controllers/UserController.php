<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{  
    public function get() {
        $users = User::all();
        return view('site.users.index', compact('users'));
    }

    public function store(Request $request) 
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'name' => ['required', 'min:3', 'max:100'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => ['required', 'min:8', 'max:20'],
            ]);

            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            auth()->login($user);

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return($e);
        }

        return redirect('/usuarios');
    }

    public function login(Request $request) 
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function loginPage()
    {
        return view('site.users.login');
    }

    public function logout()
    {
        info('oi');
        auth()->logout();
        return redirect('/');
    }
}
