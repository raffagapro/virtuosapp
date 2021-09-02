<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Role;
use App\Models\Area;
use App\Models\Clase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class TeacherListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = User::whereHas(
            'role', function($q){
                $q->where('name', 'maestro');
            }
        )->orderBy('name')->paginate(50);
        return view('admin.teacherList.index')->with(compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $request->validate([
            'nombre' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'email' => 'required|max:255',
            'curp' => 'required|max:255',
        ]);

        $workingPW = explode(' ', strtolower($request->nombre));
        $pw = 'VI'.ucfirst($workingPW[0]).'2022';
        // dd($pw, $request->all(), strtolower($request->nombre));
        $teacher = User::create([
            'name' => $request->nombre,
            'username' => $request->username,
            'email' => $request->email,
            'curp' => $request->curp,
            'status' => 1,
            'password' => Hash::make($pw),
        ]);

        $role = Role::where('name', 'maestro')->first();
        $role->user()->save($teacher);

        if ((int)$request->areaId > 0) {
            $area = Area::findOrFail((int)$request->areaId);
            $area->user()->save($teacher);
        }

        $status = 'El maestro ha sido creado exitosamente.';
        return redirect()->route('maestros.index')->with(compact('status'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = User::findOrFail($id);
        return view('admin.teacherList.details')->with(compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);
        if ($teacher->username === $request->modUserName) {
            $request->validate([
                'modNombre' => 'required|max:255',
                'modUserName' => 'required|max:255',
                'modEmail' => 'required|max:255',
                'modCurp' => 'required|max:255',
            ]);
        } else {
            $request->validate([
                'modNombre' => 'required|max:255',
                'modUserName' => 'required|unique:users,username|max:255',
                'modEmail' => 'required|max:255',
                'modCurp' => 'required|max:255',
            ]);
        }
        
        $teacher->name = $request->modNombre;
        $teacher->username = $request->modUserName;
        $teacher->email = $request->modEmail;
        $teacher->curp = $request->modCurp;
        // dd($request->modAreaId);
        if ($request->modAreaId !== null) {
            if ((int)$request->modAreaId > 0) {
                $area = Area::findOrFail((int)$request->modAreaId);
                $area->user()->save($teacher);
            }else {
                $teacher->area()->dissociate();
            }
        }
        $teacher->save();
        $status = 'El maestro ha sido actualizado exitosamente.';
        return back()->with(compact('status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // EXPANDER EN EL FUTURO PARA INCLUIR RELATED DB INFO
        $teacher = User::findOrFail($id);
        $teacher->delete();
        $status = 'El maestro ha sido eliminado exitosamente.';
        return redirect()->route('maestros.index')->with(compact('status'));
    }

    public function activate($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->status = 1;
        $teacher->save();
        $status = 'El maestro ha sido activado exitosamente.';
        return redirect()->route('maestros.index')->with(compact('status'));
    }

    public function deactivate($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->status = 0;
        $teacher->save();
        $status = 'El maestro ha sido desactivado exitosamente.';
        return redirect()->route('maestros.index')->with(compact('status'));
    }

    public function addTeacher($classID, $teacherID){
        $clase = Clase::findOrFail($classID);
        $teacher = User::findOrFail($teacherID);
        // dd($clase, $student);
        $clase->teacher = $teacher->id;
        $clase->save();
        $status = 'La clase ha sido agregada exitosamente.';
        return back()->with(compact('status'));
    }

    public function rmTeacher($classID, $teacherID){
        $clase = Clase::findOrFail($classID);
        // dd($clase);
        $clase->teacher = 0;
        $clase->save();
        $status = 'La clase ha sido eliminada exitosamente.';
        return back()->with(compact('status'));
    }
}
