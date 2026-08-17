<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\CoinGameController;

class notInGame
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->in_table) {
            $gamekeys = [
                'App\Models\CoinTable' => \App\Http\Controllers\CoinGameController::class,
                'App\Models\BaccaratTable' => \App\Http\Controllers\BaccaratGameController::class,
            ];
            $playableType = $request->user()->playable_type;

            $controllerClass = $gamekeys[$playableType];
            
            return app($controllerClass)->leave($request);
        }

        return $next($request);
    }
}
