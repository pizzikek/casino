<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        return inertia('index', ['user' => $user]);
    }
}
