<?php

namespace App\Http\Controllers;

use App\Events\PlayerListChanged;
use App\Models\BaccaratTable;
use Illuminate\Http\Request;

class BaccaratEntryPageController extends Controller
{
    public function show(Request $request){
        return inertia('games/baccarat', ['user' => $request->user()]);
    }
    public function store(Request $request)
    {

        // Validate
        $attributes = $request->validate([
            'points' => ['required', 'integer', 'min:10'],
        ]);

        // Prepare
        $user = $request->user();

        // find table
        $tables = BaccaratTable::all();
        if ($tables->count() < 1){
            BaccaratTable::create();
            $tables = BaccaratTable::all();
        }
        
        
        $lowest = $tables[0];

        foreach ($tables as $table){
            if ($table->players->count() < $lowest->players->count() && $table->players->count() < 5){
                $lowest = $table;
            }
        }
        if ($lowest->players->count() >= 5){
            $lowest = BaccaratTable::create();
        }

        $table = $lowest;

        // set up
        $user->points -= $attributes['points'];
        $user->points_curr_table = $attributes['points'];
        $user->in_table = true;
        $user->save();

        $table->players()->save($user);

        // Redirect
        event(new PlayerListChanged($request->user()->playable->players, $table->id, 'baccarat'));

        return redirect('/games/baccarat');
    }
}
