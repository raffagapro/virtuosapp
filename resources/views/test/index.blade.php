@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse ($materias as $materia)
        <p>
            <a href="{{ route('test.edit', $materia->id) }}" class="text-secondary">
                {{ $materia->name }}
            </a>
            <a
            href="javascript:void(0);"
            class="btn btn-sm btn-danger"
            onclick="event.preventDefault(); document.getElementById('{{ 'delMateria'.$materia->id }}').submit();">
                <i class="fas fa-trash"></i>
            </a>
            <form id="{{ 'delMateria'.$materia->id }}"
            action="{{ route('test.destroy', $materia->id) }}"
            method="POST"
            style="display: none;"
            >@csrf
            @method('DELETE')
            </form>
        </p>
        @empty
            <p>Sin Materias</p>
        @endforelse

        <form action="{{ route('test.store') }}" method="POST" class="form-inline">
            @csrf
            <input type="text" class="form-control" name="nombre" id="inlineFormInputName2" placeholder="Nombre">
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i>
            </button>
        </form>
    </div>
@endsection
