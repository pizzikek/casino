<?php

namespace App\Http\Controllers;

use App\Events\UserJoined;
use App\Models\CoinTable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class GameEntryPageController extends Controller
{
    public function coin_show(Request $request)
    {
        return inertia('games/coin', ['user' => $request->user()]);
    }

    public function coin_store(Request $request)
    {

        // Validate
        $attributes = $request->validate([
            'points' => ['required', 'integer', 'min:10'],
        ]);

        // Prepare
        $user = $request->user();

        // find table
        try {
            $table = CoinTable::firstOrFail();
        } catch (ModelNotFoundException $exception) {
            CoinTable::create();
            $table = CoinTable::firstOrFail();
        }

        // set up
        $user->points -= $attributes['points'];
        $user->points_curr_table = $attributes['points'];
        $user->in_table = true;
        $user->save();

        $table->users()->attach($user);

        // Redirect
        event(new UserJoined($user));
        return redirect('/games/coin');
    }
}
