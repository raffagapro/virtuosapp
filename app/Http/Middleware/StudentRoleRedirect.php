<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;


class StudentRoleRedirect
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
        $student = Role::where('name', 'estudiante')->first();

        if ($request->user() === null) {
            return redirect('/');
            }
        if ($request->user()->role_id == $student->id) {
        return $next($request);
        }
            return redirect('/');
    }
}
