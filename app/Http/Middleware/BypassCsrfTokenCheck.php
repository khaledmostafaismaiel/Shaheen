<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BypassCsrfTokenCheck
{
    public function handle(Request $request, Closure $next)
    {
        // Define URIs to bypass CSRF check
        $exceptedRoutes = [
            'api/gantt-task/task/*',
            'api/gantt-task/link*',
        ];

        foreach ($exceptedRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // Apply CSRF token verification for other routes
        return app(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)->handle($request, $next);
    }
}
