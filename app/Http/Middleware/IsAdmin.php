<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('Admin')) {
            return $next($request);
        }

        return $this->unauthenticate();
    }

    private function unauthenticate()
    {
        if (request()->wantsJson()) {
            return failedResponseJson(['message' => 'unauthenticate']);
        }

        abort(422);
    }
}
