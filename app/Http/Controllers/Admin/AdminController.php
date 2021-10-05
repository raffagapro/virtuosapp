<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Clase;
use App\Models\Homework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
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
        return view('admin.index');
    }

    public function resetPW($id)
    {
        $user = User::findOrFail($id);
        if (
            Auth::user()->role->name === "admin" || 
            Auth::user()->role->name === "super admin" || 
            Auth::user()->id === $user->id
            ) {
            dd("procede");
            $workingPW = explode(' ', strtolower($user->name));
            $pw = 'VI'.ucfirst($workingPW[0]).'2022';
            // dd($pw);
            $user->password = Hash::make($pw);
            $user->save();
            $status = 'El password ha sido reestablecido.';
            return back()->with(compact('status'));
        } else {
            $status = 'Sin autorizacion.';
            return back()->with(compact('status'));
        }
    }

    public function updatePW(Request $request, $id){
        // $user = User::findOrFail($id);
        // dd($request->all(), $id);
        $validatedData = $request->validate([
          'nuevaContraseña' => 'required|confirmed', 'min:8'
        ]);
        $user = User::findOrFail($id);
        // dd($request->nombre);
        if (Hash::check($request->contraseña, $user->password)) {
          $user->password = Hash::make($request->nuevaContraseña);
          $eStatus = 1;
          $status = 'La contraseña ha sido actualizada.';
          $user->save();
        }else {
          $eStatus = 0;
          $status = 'La contraseña actual es incorrecta.';
        }
        return back()->with(compact('status', 'eStatus'));
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function monitorIndex($id)
    {
        $teacher = User::findOrFail($id);
        // dd(Auth::user()->role->name);
        if (Auth::user()->role->name === "Admin" || Auth::user()->role->name === "Super Admin") {
            return view('admin.monitor.teacher.index')->with(compact('teacher'));
        } else {
            return redirect()->route('admin');
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sMonitorIndex($id)
    {
        $student = User::findOrFail($id);
        if (Auth::user()->role->name === "Admin" || Auth::user()->role->name === "Super Admin") {
            $chats = Chat::where('user1', $student->id)->orWhere('user2', $student->id)->get();
            return view('admin.monitor.student.index')->with(compact('student', 'chats'));
        } else {
            return redirect()->route('admin');
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function claseIndex($id)
    {
        $clase = Clase::findOrFail($id);
        // dd($clase);
        return view('admin.monitor.teacher.clase.index')->with(compact('clase'));
    }

    public function sClaseIndex($id, $studentId)
    {
        $clase = Clase::findOrFail($id);
        $student = User::findOrFail($studentId);
        // dd($clase);
        $foundChat = Chat::where('user1', $student->id)->where(function ($q) use ($clase){
          $q->where('user2', $clase->teacher()->id);
        })
        ->orWhere('user2', $student->id)->where(function ($q) use ($clase){
            $q->where('user1', $clase->teacher()->id);
        })
        ->first();
        if (!$foundChat) {
            $foundChat = Chat::create([
                'user1' => $student->id,
                'user2' => $clase->teacher()->id,
            ]);
        }
        return view('admin.monitor.student.clase.index')->with(compact('clase', 'foundChat', 'student'));
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
        return view('admin.monitor.teacher.clase.homework.index')->with(compact('homework'));
    }

    public function sShowHomework($id, $studentId)
    {
      // dd($id);
      $homework = Homework::findOrFail($id);
      $student = User::findOrFail($studentId);
      // dd($homework);
      return view('admin.monitor.student.clase.homework.index')->with(compact('homework', 'student'));
    }
}
