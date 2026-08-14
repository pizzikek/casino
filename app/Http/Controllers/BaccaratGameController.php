<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaccaratGameController extends Controller
{
    public function show(Request $request)
    {
        $table = $request->user()->playable;
        return inertia('games/table/baccarat', ['list_players' => $table->players, 'user_id' => $request->user()->id, 'table_id' => $table->id]);
    }
}
