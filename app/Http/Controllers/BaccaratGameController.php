<?php

namespace App\Http\Controllers;

use App\Events\PlayerListChanged;
use App\Models\BaccaratTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        
        if (array_all($users->toArray(), function (mixed $value): bool {
            return $value['action_table'] != null;
        })) {
            $this->deal_cards($table);
        }else{
            event(new PlayerListChanged($users, $table->id, 'baccarat'));
        }

        // redirect
        return redirect('/baccarat');

    }
    public function bet(Request $request){
        // set up
        $user = $request->user();
        $points = $user->points_curr_table;
        // Validate
        $validated = $request->validate([
            'bet' => ['required', 'numeric', "max:$points", 'min:1'],
            'bet_on' => [Rule::in(['tie','player','banker'])],
        ], [
            'bet.max' => 'The Bet can not exceed your points inside the table.',
        ]);
        // Act
        $table = $user->playable;
        $user->curr_bet = $validated['bet'];
        $user->action_table = $validated['bet_on'];
        $user->points_curr_table -= $validated['bet'];
        $user->save();

        $users = $table->players;
        if (array_all($users->toArray(), function (mixed $value): bool {
            return $value['action_table'] != null;
        })) {
            $this->deal_cards($table);
            return;
        }
        event(new PlayerListChanged($users, $table->id, 'baccarat'));
    }
    private function deal_cards(BaccaratTable $table){
        // deal cards
        $table->deck->deck->shuffle(true);
        $cards = $table->deck->deck->draw_card(4);
        $v_pl = $this->cardVal($cards[0]->rank)+$this->cardVal($cards[1]->rank);
        $cards_pl = ['cards' => [$cards[0], $cards[1]], 'value'=> $v_pl % 10];
        $v_ba = $this->cardVal($cards[2]->rank)+$this->cardVal($cards[3]->rank);
        $cards_ba = ['cards' => [$cards[2], $cards[3]], 'value'=> $v_ba % 10];

        // Check to add a third
        if ($cards_ba['value']<=2){
            $card = $table->deck->deck->draw_card();
            $v_ba = $cards_ba['value']+$this->cardVal($card[0]->rank);
            $cards_ba = ['cards' => [...$cards_ba['cards'], $card[0]], 'value'=> $v_ba % 10];
        }
        if ($cards_pl['value']<=5){
            $card = $table->deck->deck->draw_card();
            $v_pl = $cards_pl['value']+$this->cardVal($card[0]->rank);
            $cards_pl = ['cards' => [...$cards_pl['cards'], $card[0]], 'value'=> $v_pl % 10];
        }
        $table->cards = json_encode(['player' => $cards_pl,'banker'=> $cards_ba]);
        $table->save();
        
        if($cards_ba['value'] < $cards_pl['value']){
            $winner = 'player';
        }elseif($cards_ba['value'] > $cards_pl['value']){
            $winner = 'banker';
        }else{
            $winner = 'tie';
        }
        if($winner == 'tie'){
            foreach($table->players as $player){
                if($player->action_table == $winner){
                    $player->points_curr_table += $player->curr_bet * 8;
                }
            }
        }elseif($winner == 'banker' || $winner == 'player'){
            foreach($table->players as $player){
                if($player->action_table == $winner){
                    $player->points_curr_table += $player->curr_bet * 2;
                }
            }
        }
        foreach($table->players as $player){
            $player->action_table = null;
            $player->curr_bet = null;
            $player->save();
        }
        event(new PlayerListChanged($table->players,$table->id,'baccarat', $table->cards));
        
    }
    private function cardVal(int|string $val): int|null{
        if (!intval($val)){
            if(in_array($val, ["JACK", "QUEEN", "KING"])){
                return 10;
            }
            if($val == "ACE"){
                return 1;
            }
        }
        if (in_array($val, ["2", "3", "4", "5", "6", "7", "8", "9", "10"])){
            return intval($val);
        }
        return null;
    }
}
