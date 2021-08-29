<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Grado;
use App\Models\Modalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentListController extends Controller
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
        $students = User::whereHas(
            'role', function($q){
                $q->where('name', 'estudiante');
            }
        )->paginate(2);
        return view('admin.studentList.index')->with(compact('students'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workingPW = explode(' ', strtolower($request->nombre));
        $pw = 'VI'.ucfirst($workingPW[0]).'2022';
        // dd($pw, $request->all(), strtolower($request->nombre));
        $student = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'curp' => $request->curp,
            'edad' => $request->age,
            'status' => 1,
            'password' => Hash::make($pw),
        ]);

        $role = Role::where('name', 'estudiante')->first();
        $role->user()->save($student);

        if ((int)$request->gradoId > 0) {
            $grado = Grado::findOrFail((int)$request->gradoId);
            $grado->user()->save($student);
        }

        if ((int)$request->modalidadId > 0) {
            $modalidad = Modalidad::findOrFail((int)$request->modalidadId);
            $modalidad->user()->save($student);
        }

        $status = 'El estudiante ha sido creado exitosamente.';
        return redirect()->route('estudiantes.index')->with(compact('status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // EXPANDER EN EL FUNTURO PARA INCLUIR RELATED DB INFO
        $student = User::findOrFail($id);
        $student->delete();
        $status = 'El estudiante ha sido eliminado exitosamente.';
        return redirect()->route('estudiantes.index')->with(compact('status'));
    }

    public function activate($id)
    {
        $student = User::findOrFail($id);
        $student->status = 1;
        $student->save();
        $status = 'El estudiante ha sido actiavado exitosamente.';
        return redirect()->route('estudiantes.index')->with(compact('status'));
    }

    public function deactivate($id)
    {
        $student = User::findOrFail($id);
        $student->status = 0;
        $student->save();
        $status = 'El estudiante ha sido desactivado exitosamente.';
        return redirect()->route('estudiantes.index')->with(compact('status'));
    }
}
