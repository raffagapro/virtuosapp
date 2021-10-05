<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Clase;
use App\Models\Coordinator;
use App\Models\Homework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinatorController extends Controller
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
        return view('coordinator.index');
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function monitorIndex($id)
    {
        $teacher = User::findOrFail($id);
        $foundCoord = Coordinator::where('coordinator', Auth::user()->id)->where('teacher', $teacher->id)->first();
        // dd($foundCoord);
        if ($foundCoord) {
            return view('coordinator.monitor.index')->with(compact('teacher'));
        } else {
            return redirect()->route('coordinator');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function claseIndex($id)
    {
        $clase = Clase::findOrFail($id);
        return view('coordinator.monitor.clase.index')->with(compact('clase'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showHomework($id)
    {
        $homework = Homework::findOrFail($id);
        return view('coordinator.monitor.clase.homework.index')->with(compact('homework'));
    }
}
