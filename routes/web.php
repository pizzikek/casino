<?php

use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameEntryPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

// Authentication routes
Route::get('/login', [SessionController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login')->middleware('guest');

Route::get('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('/register', [CreateUserController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [CreateUserController::class, 'store'])->name('register')->middleware('guest');

// Pages
Route::get('/home', [PageController::class, 'index'])->name('home')->middleware('auth');

Route::get('/coin', [GameEntryPageController::class, 'coin_show'])->name('coin')->middleware('auth');
Route::post('/coin', [GameEntryPageController::class, 'coin_store'])->name('coin')->middleware('auth');
Route::get('/games/coin', [GameController::class, 'coin'])->name('coin')->middleware('auth');
