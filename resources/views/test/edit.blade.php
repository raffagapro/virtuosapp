@extends('layouts.app')

@section('content')
<div class="container">
    <p>{{ $materia->name }}</p>

    Crear Clase
    {{-- Change action to store class controller --}}
    <form action="{{ route('test2.store') }}" method="POST" class="form-inline">
        @csrf
        <input type="hidden" name='materiaId' value="{{ $materia->id }}">
        <input type="text" class="form-control" name="label" id="inlineFormInputName2" placeholder="Etiqueta">
        <input type="date" class="form-control" name="sdate" id="inlineFormInputName2">
        <input type="date" class="form-control" name="edate" id="inlineFormInputName2">
        @php
            $teachers = App\Models\User::whereHas(
                'role', function($q){
                    $q->where('name', 'maestro');
                }
            )->get();
        @endphp
        <select class="form-control" name="teacherId">
            @forelse ($teachers as $teacher)
                <option value={{ $teacher->id }}>{{ $teacher->name }}</option>
            @empty
                <option value=0>Sin Usuarios</option> 
            @endforelse
        </select>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i>
        </button>
    </form>
</div>
@endsection
