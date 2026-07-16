<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function coin(Request $request)
    {
        return inertia('games/table/coin');
    }
}
