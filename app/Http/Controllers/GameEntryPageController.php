<?php

namespace App\Http\Controllers;

use App\Models\CoinTable;
use App\Models\User;
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
        // Act
        $table = CoinTable::firstOrFail();
        $user = User::firstOrFail();
        $table->users()->attach($user);
        // Redirect
        return redirect('/games/coin');
    }

}
