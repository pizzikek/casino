<?php

namespace App\Http\Controllers;

use App\Events\PlayerListChanged;
use Illuminate\Http\Request;

class BaccaratGameController extends Controller
{
    public function show(Request $request)
    {
        $table = $request->user()->playable;
        return inertia('games/table/baccarat', ['list_players' => $table->players, 'user_id' => $request->user()->id, 'table_id' => $table->id]);
    }
    public function leave(Request $request)
    {
        $user = $request->user();
        // Find current Table
        $table = $user->playable;
        // add points from table back
        $user->points += $user->points_curr_table;
        $user->action_table = null;
        $user->curr_bet = null;
        $user->points_curr_table = null;
        $user->in_table = false;
        // delete record from table
        $user->playable()->disassociate();
        $user->playable_id = null;
        $user->playable_type = null;
        $user->save();
        
        if ($table->players->count() < 1){
            $table->delete();
            return redirect('/baccarat');
        }
        $users = $table->players;
        event(new PlayerListChanged($users, $table->id, 'baccarat'));
        if (array_all($users->toArray(), function (mixed $value): bool {
            return $value['action_table'] != null;
        })) {
            // dealing cards
        }

        // redirect
        return redirect('/baccarat');

    }
}
