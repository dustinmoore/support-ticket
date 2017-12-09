<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle incoming request
     *
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->is_admin != 1) {

            return redirect('home');
        }

        return $next($request);
    }
}
