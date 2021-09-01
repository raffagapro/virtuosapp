<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
        $workingPW = explode(' ', strtolower($user->nombre));
        $pw = 'VI'.ucfirst($workingPW[0]).'2022';
        $user->password = Hash::make($pw);
        $status = 'El password ha sido reestablecido.';
        return back()->with(compact('status'));
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
}
