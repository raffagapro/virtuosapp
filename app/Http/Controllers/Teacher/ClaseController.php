<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $materia = Materia::findOrFail($id);
        // dd($materia);
        return view('teacher.materia.clase.index')->with(compact('materia'));
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
        //NEEDS CODING TO DIRECT TO THE CLASS PAGE, NOT MATERIA PAGE
        // $materia = Materia::findOrFail($id);
        // return view('test.edit')->with(compact('materia'));
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

    }

    public function activate($id)
    {

    }

    public function deactivate($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //POSIBLEMENTE AGREGAR MAS CODGO PARA BORRAR TODO LO RELACIONADO CON LA CLASE

    }

    public function claseGrabber(Request $request){
        $clase = Clase::findOrFail($request->claseId);
        $teachers = User::whereHas(
            'role', function($q){
                $q->where('name', 'maestro');
            }
        )->get();
        return [$clase, $teachers];
    }
}
