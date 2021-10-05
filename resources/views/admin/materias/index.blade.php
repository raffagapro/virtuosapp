@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Materias"=>['materias']]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

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
            @if (count($materias) > 0)
              <thead>
                <tr>
                  <th class="col-9 text-left"><h5>Nombre</h5></th>
                  <th><h5>Actualizar</h5></th>
                </tr>
              </thead>  
            @endif
            <tbody>
              @forelse ($materias as $m)
                <tr>
                  <td class="text-left"><a href="{{ route('clase.index', $m->id) }}">{{ ucwords($m->name) }}</a></td>
                  <td>
                    <span class="btn btn-sm btn-primary text-light mr-2 materiaBtn" data-toggle="tooltip" data-placement="top" title="Modificar" id="{{ $m->id }}"><i class="fas fa-pen" data-toggle="modal" data-target="#materiasModModal"></i></span>
                    <x-delete-btn
                      :tooltip="'Borrar'"
                      :id="[$m->id]"
                      :text="'¿Deseas eliminar la materia?'"
                      :elemName="'delMateria'"
                      :routeName="'materias.destroy'"
                    />
                  </td>
                </tr>
              @empty
                <div class="alert alert-danger" role="alert">
                  Sin materias
                </div>
              @endforelse
            </tbody>
          </table>
          {{-- Paginator --}}
          <div class="d-flex justify-content-center">
            {{$materias->links()}}
          </div>
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
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" placeholder="Nombre">
            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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
        <form action="{{ route('materias.update', 0) }}" id="modalForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id='materiaModID'>
          <div class="form-group">
            <input type="text" class="form-control @error('modNombre') is-invalid @enderror" id="modNombre" name="modNombre" placeholder="Nombre">
            @error('modNombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary float-right">Modificar</button>
      </form>
      </div>
    </div>
  </div>
</div>

@if ($errors->has('nombre'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#materiasModal').modal('show'); });
  </script>
@endif

@if ($errors->has('modNombre'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#materiasModModal').modal('show'); });
  </script>
@endif

@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/materiaSwitcher.js') }}" ></script>
@endsection