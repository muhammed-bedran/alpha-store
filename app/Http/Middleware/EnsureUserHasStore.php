<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class EnsureUserHasStore
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user =Auth::user();
        if (!$user->store_id) {
            return redirect()->route('user.store.create')
            ->with('warning', 'You need to create a store before accessing this page.');
        }
        return $next($request);
    }
}
