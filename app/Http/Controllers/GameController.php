<?php

namespace App\Http\Controllers;

use App\Events\UserLeft;
use App\Events\UserPlacedBet;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function coin(Request $request)
    {
        //$list_players = $request->user()->coinTables()->firstOrFail()->users()->where('users.id', '!=', $request->user()->id)->get();
        //foreach ($list_players as $player) {
        //    $player = ['App\misc\misc', 'safe_items']($player);
        //}
        return inertia('games/table/coin', ['list_players' => $request->user()->coinTables()->firstOrFail()->users()->where('users.id', '!=', $request->user()->id)->get(), 'user' => $request->user()]); // $request->user()->coinTables()->first()->users()
    }

    public function bet_num(Request $request)
    {
        $user = $request->user();
        $points_curr = $user['points_curr_table'];
        // Validate
        $attributes = $request->validate([
            'bet' => ['required', 'numeric', "max:$points_curr"],
        ], [
            'bet.max' => 'The Bet can not exceed your points inside the table.',
        ]);
        // $table = $user->coinTables()->firstOrFail();
        // act
        $user->action_table = 'num';
        $user->points_curr_table -= $attributes['bet'];
        $user->curr_bet = $attributes['bet'];
        // return
        $user->save();
        event(new UserPlacedBet('hello'));
    }

    public function bet_face(Request $request)
    {
        $user = $request->user();
        $points_curr = $user['points_curr_table'];
        // Validate
        $attributes = $request->validate([
            'bet' => ['required', 'numeric', "max:$points_curr"],
        ], [
            'bet.max' => 'The Bet can not exceed your points inside the table.',
        ]);
        // $table = $user->coinTables()->firstOrFail();
        // act
        $user->action_table = 'face';
        $user->points_curr_table -= $attributes['bet'];
        $user->curr_bet = $attributes['bet'];
        // return
        $user->save();
        event(new UserPlacedBet('hello'));
    }

    public function leave(Request $request)
    {
        $user = $request->user();
        event(new UserLeft($user));
        // Find current Table
        $table = $user->coinTables();
        // add points from table back
        $user->points += $user->points_curr_table;
        $user->action_table = null;
        $user->curr_bet = null;
        $user->points_curr_table = null;
        $user->in_table = false;
        $user->save();
        // delete record from table
        $table->detach();

        // redirect
        return redirect('/coin');
    }
}
