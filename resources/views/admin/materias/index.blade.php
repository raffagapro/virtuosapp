@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-4">

            </div>
            <h3 class="col-4">Materias</h3>
            <div class="col-4">
              <button class="btn btn-primary float-right" data-toggle="modal" data-target="#materiasModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="col-9 text-left"><h5>Nombre</h5></th>
                <th><h5>Actualizar</h5></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($materias as $m)
                <tr>
                  <td class="text-left"><a href="{{ route('clase.index', $m->id) }}">{{ $m->name }}</a></td>
                  <td>
                    <span class="btn btn-primary text-light mr-2 materiaBtn" id="{{ $m->id }}"><i class="fas fa-pen" data-toggle="modal" data-target="#materiasModModal"></i></span>
                    <a
                    href="javascript:void(0);"
                    class="btn btn-danger text-light"
                    onclick="event.preventDefault(); document.getElementById('{{ 'delMateria'.$m->id }}').submit();">
                      <i class="far fa-trash-alt"></i>
                    </a>
                    <form id="{{ 'delMateria'.$m->id }}"
                    action="{{ route('materias.destroy', $m->id) }}"
                    method="POST"
                    style="display: none;"
                    >@csrf
                    @method('DELETE')
                    </form>
                  </td>
                </tr>
              @empty
                <div class="alert alert-danger" role="alert">
                  Sin materias
                </div>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar Materia -->
<div class="modal fade" id="materiasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Materia</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('materias.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="text" class="form-control" name="nombre" placeholder="Nombre">
          </div>
          <button type="submit" class="btn btn-primary float-right">Agregar</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Materia -->
<div class="modal fade" id="materiasModModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Materia</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('materias.update', $m->id) }}" id="modalForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id='materiaModID'>
          <div class="form-group">
            <input type="text" class="form-control" id="modNombre" name="modNombre" placeholder="Nombre">
          </div>
          <button type="submit" class="btn btn-primary float-right">Modificar</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('js/ajax/materiaSwitcher.js') }}" ></script>
@endsection