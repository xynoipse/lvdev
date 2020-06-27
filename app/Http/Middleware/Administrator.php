<?php

namespace App\Http\Middleware;

use Closure;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $super = null)
    {
        $admin = ['superadmin', 'admin'];
        if ($super == 'super') $admin = 'superadmin';

        $admin = $request->user()->hasRole($admin);
        if (!$admin) return response()->json(['message' => 'Permission denied'], 403);

        return $next($request);
    }
}
