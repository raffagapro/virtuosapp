@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [$clase->label=>['maestroDash.clase', $clase->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <h3>Tareas</h3>
          <div class="row">
            {{--  TABS  --}}
            <div class="col">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#activas"><h4>Activas</h4>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#cerradas"><h4>Vencidas</h4></a>
                </li>
              </ul>
            </div>
            {{--  AGREGAR TAREA BTN  --}}
            <div class="col-3 ml-auto">
              <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addTareaModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <div class="tab-content">
            {{-- TAB ABIERTAS --}}
            @php
              $date = date('Y-m-d');
            @endphp
            <div class="tab-pane active" id="activas">
              @include('teacher.clase.activas')
            </div>
            {{-- TAB CERRADAS --}}
            <div class="tab-pane" id="cerradas">
              @include('teacher.clase.cerradas')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Tarea -->
<div class="modal fade" id="addTareaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Tarea</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('homework.store') }}" method="POST">
          @csrf
          <input type="hidden" name="claseId" value="{{ $clase->id }}">
          {{--  TITULO  --}}
          <div class="form-group">
            <input type="text" class="form-control" name="titulo" placeholder="Titulo">
          </div>
          {{--  BODY  --}}
          <div class="form-group">
            <textarea class="form-control" id="body" name="body" placeholder="Instrucciones" rows="8"></textarea>
          </div>
          {{--  VLINK  --}}
          <div class="form-group">
            <input type="text" class="form-control" name="vlink" placeholder="Video">
          </div>
          {{-- STUDENTS --}}
          <div class="form-group">
            @php
                $students = $clase->students;
            @endphp
            <select class="form-control" name="studentId">
                <option value=0>Grupal</option>
                @forelse ($students as $s)
                    <option value={{ $s->id }}>{{ $s->name }}</option>
                @empty
                    <option value=0 disabled>No hay estudiantes registrados</option>
                @endforelse
            </select>
          </div>
          {{-- FECHA DE ENTREGA --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Fecha de Entrega</small>
              <input type="date" class="form-control" name="edate">
          </div>
          <button type="submit" class="btn btn-primary float-right">Agregar</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Tarea -->
<div class="modal fade" id="modTareaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar <span id="hwTitleCont"></span></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="modHWForm" action="{{ route('homework.update', 0) }}" method="POST">
          @csrf
    			@method('PUT')
          <input type="hidden" name="homeworkId" id="homeworkId">
          {{--  TITULO  --}}
          <div class="form-group">
            <input type="text" class="form-control" id="modTitulo" name="modTitulo" placeholder="Titulo">
          </div>
          {{--  BODY  --}}
          <div class="form-group">
            <textarea class="form-control" id="body" id="modBody" name="modBody" placeholder="Instrucciones" rows="8"></textarea>
          </div>
          {{--  VLINK  --}}
          <div class="form-group">
            <input type="text" class="form-control" id="modVlink" name="modVlink" placeholder="Video">
          </div>
          {{-- STUDENTS --}}
          <div class="form-group">
            <select class="form-control" name="modStudentId" id="modStudentId">
            </select>
          </div>
          {{-- FECHA DE ENTREGA --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Fecha de Entrega</small>
            <input type="date" class="form-control" name="modEdate" id="modEdate">
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
<script src="{{ asset('js/ajax/teacherDashHomeworkSwitcher.js') }}" ></script>
@endsection