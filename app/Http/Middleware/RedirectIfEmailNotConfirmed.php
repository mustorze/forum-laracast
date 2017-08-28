<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class RedirectIfEmailNotConfirmed
 * @package App\Http\Middleware
 */
class RedirectIfEmailNotConfirmed
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()->confirmed) {
            return redirect('/threads')->with('flash', 'You must first confirm your email address.');
        }

        return $next($request);
    }
}
