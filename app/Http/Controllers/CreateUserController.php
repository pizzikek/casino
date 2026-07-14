<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateUserController extends Controller
{
    public function index()
    {
        return inertia('auth/register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('/home');

    }
}
