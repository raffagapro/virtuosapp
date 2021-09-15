<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;


class CoordinatorRoleRedirect
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
        $coordinator = Role::where('name', 'coordinador')->first();

        if ($request->user() === null) {
            return redirect('/');
            }
        if ($request->user()->role_id == $coordinator->id) {
        return $next($request);
        }
            return redirect('/');
    }
}
