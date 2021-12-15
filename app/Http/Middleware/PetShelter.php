<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetShelter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'pet_shelter') {
            return $next($request);
        }
        return redirect('home')->with('error', "Oops! Only Pet Shelter can access this menu.");
    }
}
