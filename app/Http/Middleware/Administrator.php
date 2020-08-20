<?php

namespace App\Http\Middleware;

use App\Acl;
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
        $admin = [Acl::ROLE_SUPERADMIN, Acl::ROLE_ADMIN];
        if ($super == 'super') $admin = Acl::ROLE_SUPERADMIN;

        $admin = $request->user()->hasRole($admin);
        if (!$admin) return response()->json(['message' => 'Permission denied'], 403);

        return $next($request);
    }
}
