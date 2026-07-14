<?php

use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::get('/login', [SessionController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login')->middleware('guest');
Route::get('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('/register', [CreateUserController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [CreateUserController::class, 'store'])->name('register')->middleware('guest');
