<?php

namespace App\Http\Controllers;

use App\Events\CoinFlipped;
use App\Events\PlayerListChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GameController extends Controller
{
    public function coin(Request $request)
    {
        // $list_players = $request->user()->coinTables()->firstOrFail()->users()->where('users.id', '!=', $request->user()->id)->get();
        // foreach ($list_players as $player) {
        //    $player = ['App\misc\misc', 'safe_items']($player);
        // }
        return inertia('games/table/coin', [
            'list_players' => $request->user()->playable->players,
            'user_id' => $request->user()->id,
            'start_face' => $request->user()->playable['coin_side']]);
    }

    public function bet_num(Request $request)
    {
        $this->bet('num', $request);
    }

    public function bet_face(Request $request)
    {
        $this->bet('face', $request);
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


        $users = $table->players;
        event(new PlayerListChanged($users));
        if (array_all($users->toArray(), function (mixed $value): bool {
            return $value['action_table'] != null;
        })) {
            $this->flip_coin($table);
        }

        // redirect
        return redirect('/coin');

    }

    private function bet(string $on, Request $request)
    {
        $user = $request->user();
        $points_curr = $user['points_curr_table'];
        // Validate
        $attributes = $request->validate([
            'bet' => ['required', 'numeric', "max:$points_curr", 'min:1'],
        ], [
            'bet.max' => 'The Bet can not exceed your points inside the table.',
        ]);
        // $table = $user->coinTables()->firstOrFail();
        // act
        $user->action_table = $on;
        $user->points_curr_table -= $attributes['bet'];
        $user->curr_bet = $attributes['bet'];
        // return
        $user->save();

        $users = $request->user()->playable->players;

        if (array_all($users->toArray(), function (mixed $value): bool {
            return $value['action_table'] != null;
        })) {
            $this->flip_coin($request->user()->playable);
        } else {
            event(new PlayerListChanged($users));
        }
    }

    private function flip_coin(mixed $table)
    {
        $face = Arr::random(['num', 'face']);

        $table->coin_side = $face;
        foreach ($table->players as $user) {
            if ($user->action_table == $face) {
                $user->points_curr_table += $user->curr_bet * 2;
                $table->bank_money -= $user->curr_bet;
            } else {
                $table->bank_money += $user->curr_bet;
            }
            $user->curr_bet = null;
            $user->action_table = null;
            $user->save();
        }
        $table->save();

        $time = mt_rand(3, 7);

        event(new CoinFlipped($face, $table->players, $time));

    }
}
