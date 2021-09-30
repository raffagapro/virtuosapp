<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Area;
use App\Models\Coordinator;
use App\Services\PurgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coords = User::whereHas(
            'role', function($q){
                $q->where('name', 'coordinador');
            }
        )->orderBy('name')->paginate(50);
        return view('admin.coordinator.index')->with(compact('coords'));
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
        $coordinator = User::create([
            'name' => $request->nombre,
            'username' => $request->username,
            'email' => $request->email,
            'curp' => $request->curp,
            'status' => 1,
            'password' => Hash::make($pw),
        ]);

        $role = Role::where('name', 'coordinador')->first();
        $role->user()->save($coordinator);

        if ((int)$request->areaId > 0) {
            $area = Area::findOrFail((int)$request->areaId);
            $area->user()->save($coordinator);
        }

        $status = 'El coordinador ha sido creado exitosamente.';
        return redirect()->route('coordinator.index')->with(compact('status'));
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
        $coordinator = User::findOrFail($id);
        return view('admin.coordinator.edit')->with(compact('coordinator'));
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
        $coordinator = User::findOrFail($id);
        // dd($coordinator);
        if ($coordinator->username === $request->modUserName) {
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
        
        $coordinator->name = $request->modNombre;
        $coordinator->username = $request->modUserName;
        $coordinator->email = $request->modEmail;
        $coordinator->curp = $request->modCurp;
        // dd($request->modAreaId);
        if ($request->modAreaId !== null) {
            if ((int)$request->modAreaId > 0) {
                $area = Area::findOrFail((int)$request->modAreaId);
                $area->user()->save($coordinator);
            }else {
                $coordinator->area()->dissociate();
            }
        }
        $coordinator->save();
        $status = 'La informacion ha sido actualizada exitosamente.';
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
        $coordinator = User::findOrFail($id);
        $purge = new PurgeService();
        $purge->purge($coordinator);
        $coordinator->delete();
        $status = 'El coordinador ha sido eliminado exitosamente.';
        return redirect()->route('coordinator.index')->with(compact('status'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function teacherSearcher(Request $request){
        $coordinator = User::findOrFail($request->coordId);
        $teachers = User::where('name', 'LIKE', '%'.$request->value.'%')  
                        ->whereHas(
                            'role', function($q){
                                $q->where('name', 'maestro');
                            }
                        )->get();
        return [$teachers, $coordinator];
    }

    public function addTeacher($coordId, $teacherID){
        $coordinator = User::findOrFail($coordId);
        $teacher = User::findOrFail($teacherID);
        $foundCoordObj = Coordinator::where('coordinator', $coordinator->id)->where('teacher', $teacher->id)->first();
        // dd($coordinator, $teacher, $foundCoordObj);
        if (!$foundCoordObj) {
            $foundCoordObj = Coordinator::create([
                'coordinator' => $coordinator->id,
                'teacher' => $teacher->id,
            ]);
        }
        $status = 'El maestro ha sido agregado exitosamente.';
        return back()->with(compact('status'));
    }

    public function rmTeacher($coordObjID){
        $coordOnj = Coordinator::findOrFail($coordObjID);
        // dd($coordObjID, $coordOnj);
        $coordOnj->delete();
        $status = 'El maestro ha sido eliminado exitosamente.';
        return back()->with(compact('status'));
    }
}
