<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lets a request through ONLY if the logged-in user is a superadmin.
 *
 * Use it on a route together with auth:sanctum, e.g.:
 *   Route::middleware(['auth:sanctum', 'superadmin'])->group(...);
 *
 * auth:sanctum runs first and guarantees there IS a logged-in user; this
 * middleware then checks that user's role.
 */
class EnsureUserIsSuperadmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // $request->user() is the user the token belongs to.
        if ($request->user()?->role !== 'superadmin') {
            // 403 = "you're logged in, but not allowed to do this".
            abort(403, 'This action requires superadmin access.');
        }

        return $next($request);
    }
}
