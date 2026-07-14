<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateUserController extends Controller
{
    public function index(){
        return inertia('register');
    }
    public function store(){
        $attributes = request()->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('/');

    }
}
