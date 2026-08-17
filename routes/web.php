<?php

use App\Http\Controllers\BaccaratEntryPageController;
use App\Http\Controllers\BaccaratGameController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\CoinGameController;
use App\Http\Controllers\CoinEntryPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\inCorrectGame;
use App\Http\Middleware\inGame;
use App\Http\Middleware\notInGame;
use App\misc\DeckOfCards;
use App\Models\CardDeck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

// Authentication routes
Route::get('/login', [SessionController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login')->middleware('guest');

Route::get('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth')->middleware(notInGame::class);

Route::get('/register', [CreateUserController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [CreateUserController::class, 'store'])->name('register')->middleware('guest');


// Pages
Route::get('/home', [PageController::class, 'index'])->name('home')->middleware('auth')->middleware(notInGame::class);
Route::get('/coin', [CoinEntryPageController::class, 'show'])->name('coin')->middleware('auth')->middleware(notInGame::class);
Route::get('/baccarat', [BaccaratEntryPageController::class, 'show'])->name('baccarat')->middleware('auth')->middleware(notInGame::class);


// Games
// Coin Flip
Route::post('/coin', [CoinEntryPageController::class, 'store'])->name('coin')->middleware('auth')->middleware(notInGame::class);
Route::get('/games/coin', [CoinGameController::class, 'coin'])->name('coin')->middleware('auth')->middleware(inGame::class)->middleware(inCorrectGame::class . ':App\Models\CoinTable');
// Actions
Route::post('/games/coin/num', [CoinGameController::class, 'bet_num'])->name('coin')->middleware('auth')->middleware(inGame::class)->middleware(inCorrectGame::class . ':App\Models\CoinTable');
Route::post('/games/coin/face', [CoinGameController::class, 'bet_face'])->name('coin')->middleware('auth')->middleware(inGame::class)->middleware(inCorrectGame::class . ':App\Models\CoinTable');

// Baccarat
Route::post('/baccarat', [BaccaratEntryPageController::class, 'store'])->name('baccarat')->middleware('auth')->middleware(notInGame::class);
Route::get('/games/baccarat', [BaccaratGameController::class, 'show'])->name('baccarat')->middleware('auth')->middleware(inGame::class)->middleware(inCorrectGame::class . ':App\Models\BaccaratTable');


Route::post('/coin/leave', [CoinGameController::class, 'leave'])->name('leave')->middleware('auth');
Route::post('/baccarat/leave', [BaccaratGameController::class, 'leave'])->name('leave')->middleware('auth');




Route::get('/deck/new', function () {
    $deck_of_cards = new CardDeck();
    $deck_of_cards->deck = new DeckOfCards(2, false);
    $deck_of_cards->save();

    dd($deck_of_cards->deck);
});
Route::get('/deck/shuffle', function () {
    $deck_of_cards = CardDeck::all()->firstOrFail();
    $deck_of_cards->deck->shuffle();
    $deck_of_cards->save();

    dd($deck_of_cards->deck);
});

Route::get('/deck/draw', function () {
    $deck_of_cards = CardDeck::all()->firstOrFail();
    $drawncards = $deck_of_cards->deck->draw_card();
    $deck_of_cards->save();

    dd($drawncards);
});
