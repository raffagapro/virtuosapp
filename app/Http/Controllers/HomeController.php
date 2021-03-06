<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $guest = Role::where('name', 'guest')->first();
        $admin = Role::where('name', 'admin')->first();
        $sAdmin = Role::where('name', 'super admin')->first();
        $coordinator = Role::where('name', 'coordinador')->first();
        $teacher = Role::where('name', 'maestro')->first();
        $student = Role::where('name', 'estudiante')->first();

        if (Auth::user()->role_id == $guest->id) {
            return redirect()->route('guest');
        }
        elseif (Auth::user()->role_id == $admin->id) {
            return redirect()->route('admin');
        }
        elseif (Auth::user()->role_id == $sAdmin->id) {
            return redirect()->route('admin');
        }
        elseif (Auth::user()->role_id == $coordinator->id) {
            return redirect()->route('coordinator');
        }
        elseif (Auth::user()->role_id == $teacher->id) {
            return redirect()->route('teacher');
        }
        elseif (Auth::user()->role_id == $student->id) {
            return redirect()->route('student');
        }
        return view('home');
    }  
}