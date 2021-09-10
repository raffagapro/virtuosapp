@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Materias"=>['materias.index'],"Clases"=>['clase.index', $clase->id], $clase->label => ['clase.edit', $clase->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <h3>{{ $clase->label }}</h3>
          <div class="row mb-3">
            <div class="col-6 ml-auto">
              @if ($clase->teacher === null || $clase->teacher === 0)
                <p class="text-secondary text-danger">Docente: Sin Maestro</p>
              @else
                <p class="text-secondary">Docente: {{ $clase->teacher()->name }}</p>
              @endif
              @php
                  $sdate = date('M d', strtotime($clase->sdate));
                  $edate = date('M d', strtotime($clase->edate));
              @endphp
              <small class="text-secondary">{{ $sdate.' / '.$edate }}</small>
            </div>
            <div class="col-3">
              <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addStudentModal">
                <i class="fas fa-user-graduate" data-toggle="tooltip" data-placement="top" title="Agregar Estudiante"></i>
              </button>
              <button class="btn btn-primary float-right mr-1" data-toggle="modal" data-target="#modClassModal">
                <i class="fas fa-pen" data-toggle="tooltip" data-placement="top" title="Modificar Clase"></i>
              </button>
            </div>
          </div>
          <table class="table table-bordered">
            @if (count($clase->students) > 0)
              <thead>
                <tr>
                  <th class="col-9 text-left"><h5>Alumnos</h5></th>
                  @if ($clase->status === 1)
                    <th class="col-3"><h5>Eliminar</h5></th>
                  @endif
                </tr>
              </thead>
            @endif
            <tbody>
              @forelse ($clase->students as $s)
                <tr>
                  {{-- NOMBRE --}}
                  <td class="text-left"><a href="{{ route('estudiantes.edit', $s->id) }}">{{ ucwords($s->name) }}</a></td>
                  @if ($clase->status === 1)
                    {{-- ACTUALIZA --}}
                    <td>
                      <a
                        href="javascript:void(0);"
                        data-toggle="tooltip" data-placement="top" title="Eliminar"
                        class="btn btn-sm btn-danger text-light"
                        onclick="
                          event.preventDefault();
                          swal.fire({
                            text: '¿Deseas eliminar el estudiante de la clase?',
                            showCancelButton: true,
                            cancelButtonText: `Cancelar`,
                            cancelButtonColor:'#62A4C0',
                            confirmButtonColor:'red',
                            confirmButtonText:'Eliminar',
                            icon:'error',
                          }).then((result) => {
                            if (result.isConfirmed) {
                              document.getElementById('{{ 'delStudent'.$s->id }}').submit();
                            }
                          });"
                      >
                        <i class="far fa-trash-alt"></i>
                      </a>
                      <form id="{{ 'delStudent'.$s->id }}"
                        action="{{ route('clase.rmStudent', [$clase->id, $s->id]) }}"
                        method="POST"
                        style="display: none;"
                      >@csrf
                      @method('GET')
                      </form>
                    </td>
                  @endif
                </tr>
              @empty
                <div class="alert alert-danger" role="alert">
                  Sin estudiantes registrados
                </div>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Class -->
<div class="modal fade" id="modClassModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Modificar {{ $clase->label }}</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('clase.update', $clase->id) }}" id="modalForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name='materiaId' value="{{ $clase->materia->id }}">
          {{-- LABEL --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modLabel') is-invalid @enderror" name="modLabel" placeholder="Etiqueta" value="{{ $clase->label }}">
            @error('modLabel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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
            <select class="form-control" name="modteacherId">
              <option value=0>Sin Maestro</option>
              @forelse ($teachers as $teacher)
                @if ($teacher->id === $clase->teacher)
                  <option value={{ $teacher->id }} selected>{{ $teacher->name }}</option> 
                @else
                  <option value={{ $teacher->id }}>{{ $teacher->name }}</option>
                @endif
              @empty
                  <option value=0 disabled>No hay maestros registrados</option>
              @endforelse
            </select>
          </div>
          {{-- FECHAS --}}
          <div class="form-group row">
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Fecha de Inicio</small>
              <input type="date" class="form-control" name="modSdate" value="{{ $clase->sdate }}">
            </div>
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Fecha de Cierre</small>
              <input type="date" class="form-control" name="modEdate" value="{{ $clase->edate }}">
            </div>
          </div>

          <button type="submit" class="btn btn-primary float-right">Modificar</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Estudiante -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Agregar Estudiante</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="studentSearch" placeholder="Nombre del estudiante">
          <input type="hidden" id="claseId" value="{{ $clase->id }}">
        </div>
        <table class="table table-bordered">
          <tbody id="stidentListCont">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@if ($errors->has('modLabel'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#modClassModal').modal('show'); });
  </script>
@endif

@if(session('status'))
  <x-success-alert :message="session('status')"/>
@endif
@isset($status)
  <x-success-alert :message="$status"/>
@endisset
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/claseInvSwitcher.js') }}" ></script>
@endsection