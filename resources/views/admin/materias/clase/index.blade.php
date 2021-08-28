@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Materias"=>'materias.index',"Clases"=>'clase.index']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <h3>{{ $materia->name }}</h3>
          <div class="row mb-3">
            <div class="col">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#activas"><h4>Activas</h4>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#cerradas"><h4>Cerradas</h4></a>
                </li>
              </ul>
            </div>
            <div class="col-3 ml-auto">
              <button class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Abrir Clase<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <div class="tab-content">
            {{-- TAB ABIERTAS --}}
            <div class="tab-pane active" id="activas">
              @include('admin.materias.clase.activas')
            </div>
            {{-- TAB CERRADAS --}}
            <div class="tab-pane" id="cerradas">
              @include('admin.materias.clase.cerradas')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Abrir Clase de {{ $materia->name }}</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('clase.store') }}" method="POST">
          @csrf
          <input type="hidden" name='materiaId' value="{{ $materia->id }}">
          {{-- LABEL --}}
          <div class="form-group">
            <input type="text" class="form-control" name="label" placeholder="Etiqueta">
          </div>
          {{-- TEACHERS --}}
          <div class="form-group">
            @php
                $teachers = App\Models\User::whereHas(
                    'role', function($q){
                        $q->where('name', 'maestro');
                    }
                )->get();
            @endphp
            <select class="form-control" name="teacherId">
                <option value=0>Sin Maestro</option>
                @forelse ($teachers as $teacher)
                    <option value={{ $teacher->id }}>{{ $teacher->name }}</option>
                @empty
                    <option value=0 disabled>No hay maestros registrados</option>
                @endforelse
            </select>
          </div>
          {{-- FECHAS --}}
          <div class="form-group row">
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Fecha de Inicio</small>
              <input type="date" class="form-control" name="sdate">
            </div>
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Fecha de Cierre</small>
              <input type="date" class="form-control" name="edate">
            </div>
          </div>
          <button type="submit" class="btn btn-primary float-right">Abrir</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Materia -->
<div class="modal fade" id="modClassModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Modificar <span id="claseNameCont"></span></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('clase.update', 0) }}" id="modalForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name='materiaId' value="{{ $materia->id }}">
          {{-- LABEL --}}
          <div class="form-group">
            <input type="text" class="form-control" id="modLabel" name="modLabel" placeholder="Etiqueta">
          </div>
          {{-- TEACHERS --}}
          <div class="form-group">
            <select class="form-control" id="teacherId" name="modteacherId">
                <option value=0>Sin Maestro</option>
            </select>
          </div>
          {{-- FECHAS --}}
          <div class="form-group row">
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Fecha de Inicio</small>
              <input type="date" class="form-control" id="modSdate" name="modSdate">
            </div>
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Fecha de Cierre</small>
              <input type="date" class="form-control" id="modEdate" name="modEdate">
            </div>
          </div>

          <button type="submit" class="btn btn-primary float-right">Modificar</button>
      </form>
      </div>
    </div>
  </div>
</div>

@if(session('status'))
  <x-success-alert :message="session('status')"/>
@endif
@isset($status)
  <x-success-alert :message="$status"/>
@endisset
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/claseSwitcher.js') }}" ></script>
@endsection
