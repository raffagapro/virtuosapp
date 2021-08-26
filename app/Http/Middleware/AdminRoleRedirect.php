<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;


class AdminRoleRedirect
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
        $admin = Role::where('name', 'admin')->first();
        $sAdmin = Role::where('name', 'super admin')->first();

        if ($request->user() === null) {
            return redirect('/');
            }
        if ($request->user()->role_id == $admin->id || $request->user()->role_id == $sAdmin->id) {
        return $next($request);
        }
            return redirect('/');
    }
}
