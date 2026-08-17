<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class inCorrectGame
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $game): Response
    {
        if ($request->user()->playable_type !== $game){
            return redirect('/home'); 
        }
        return $next($request);
    }
}
