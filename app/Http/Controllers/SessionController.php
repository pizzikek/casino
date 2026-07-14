<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function index()
    {
        return inertia('login');
    }

    public function store()
    {
        // Validate
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // login
        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'The credentials dont match our records.',
            ]);
        }
        request()->session()->regenerate();

        // redirect
        return redirect('/');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/login');
    }
}
