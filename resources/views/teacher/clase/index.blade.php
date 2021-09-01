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
          <div class="row mb-3">
            <div class="col-4">

            </div>
            <h3 class="col-4">Tareas</h3>
            <div class="col-4">
              <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addTareaModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <table class="table table-bordered">
            @php
                // dd(count($clase->homeworks));
            @endphp
            @if (count($clase->homeworks) > 0)
              <thead>
                <tr>
                  <th class="col-4 text-left"><h5>Nombre</h5></th>
                  <th><h5>Fecha de entrega</h5></th>
                  <th><h5>Asignado</h5></th>
                  <th><h5>Actualizar</h5></th>
                </tr>
              </thead> 
            @endif
            <tbody>
              @forelse ($clase->homeworks->sortBy('edate', SORT_REGULAR, true) as $h)
                <tr>
                  <td class="text-left"><a href="{{ route('maestroDash.tarea', $h->id) }}">{{ $h->title }}</a></td>
                  @php
                      $edate = date('M d', strtotime($h->edate));
                  @endphp
                  <td>{{ $edate }}</td>
                  <td>
                    @if ($h->student === 0)
                      <span class="badge bg-info tarea-status">Grupal</span> 
                    @else
                      <span class="badge bg-warning tarea-status">{{ $h->getStudent()->name }}</span> 
                    @endif
                  </td>
                  <td>
                    <span class="btn btn-sm btn-primary text-white mr-2 homeworkBtn" id="{{ $h->id }}" data-toggle="modal" data-target="#modTareaModal"><i class="fas fa-pen" data-toggle="tooltip" data-placement="top" title="Modificar"></i></span>
                    <a
                      href="javascript:void(0);"
                      class="btn btn-sm btn-danger text-white mr-2"
                      data-toggle="tooltip" data-placement="top" title="Borrar"
                      onclick="
                          event.preventDefault();
                          swal.fire({
                            text: '¿Deseas eliminar la tarea?',
                            showCancelButton: true,
                            cancelButtonText: `Cancelar`,
                            cancelButtonColor:'#62A4C0',
                            confirmButtonColor:'red',
                            confirmButtonText:'Eliminar',
                            icon:'error',
                          }).then((result) => {
                            if (result.isConfirmed) {
                              document.getElementById('{{ 'delTarea'.$h->id }}').submit();
                            }
                          });"
                    >
                      <i class="far fa-trash-alt"></i>
                    </a>
                    <form id="{{ 'delTarea'.$h->id }}"
                    action="{{ route('homework.destroy', $h->id) }}"
                    method="POST"
                    style="display: none;"
                    >@csrf
                    @method('DELETE')
                    </form>
                  </td>
                </tr>
              @empty
                <div class="alert alert-danger" role="alert">
                  Sin tareas
                </div>
              @endforelse
            </tbody>
          </table>
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