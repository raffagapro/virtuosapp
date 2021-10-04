<div class="card border-secondary text-center">
    <div class="card-body">
      <h3>Tareas</h3>
      <div class="row">
        {{--  TABS  --}}
        <div class="col">
          <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#activas">
                    <h4>Activas <span class="badge badge-light">{{ count($activas) }}</span></h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cerradas">
                    <h4>Vencidas <span class="badge badge-light">{{ count($cerradas) }}</span></h4>
                </a>
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
        <div class="tab-pane active" id="activas">
            <x-teacher.homework-tab :user="Auth::user()" :homeworks="$activas" :monitor="$monitor"/>
        </div>
        {{-- TAB CERRADAS --}}
        <div class="tab-pane" id="cerradas">
            <x-teacher.homework-tab :user="Auth::user()" :homeworks="$cerradas" :monitor="$monitor"/>
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
            @if (!$monitor)
                <form action="{{ route('homework.store') }}" method="POST">
            @else
                @if ($user->role->name === "Coordinador")
                    <form action="{{ route('monitor.newHomework') }}" method="POST">
                @else
                    <form action="{{ route('admin.teacherNewHomeworkMonitor') }}" method="POST">
                @endif
            @endif
            @csrf
            <input type="hidden" name="claseId" value="{{ $clase->id }}">
            {{--  TITULO  --}}
            <div class="form-group">
              <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" placeholder="Titulo" value="{{ old('titulo') }}">
              @error('titulo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            {{--  BODY  --}}
            <div class="form-group">
              <textarea class="form-control tinyEditor @error('body') is-invalid @enderror" id="body" name="body" placeholder="Instrucciones" rows="8">{{ old('body') }}</textarea>
              @error('body')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            {{--  VLINK  --}}
            <div class="form-group">
              <input type="text" class="form-control" name="vlink" placeholder="Enlance" value="{{ old('vlink') }}">
            </div>
            {{-- STUDENTS --}}
            <div class="form-group">
              @php
                  $students = $clase->students;
              @endphp
              <select class="form-control" name="studentId" value="{{ old('student') }}">
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
              <small class="form-text text-muted">Fecha de Entrega</small>
                <input type="date" class="form-control" name="edate" value="{{ old('edate') }}">
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
            @if (!$monitor)
                <form id="modHWForm" action="{{ route('homework.update', 0) }}" method="POST">
            @else
                @if ($user->role->name === "Coordinador")
                    <form id="modHWForm" action="{{ route('monitor.updateHomework', 0) }}" method="POST">
                @else
                    <form id="modHWForm" action="{{ route('admin.teacherUpdateHomework', 0) }}" method="POST"> 
                @endif
            @endif
            @csrf
                  @method('PUT')
            <input type="hidden" name="homeworkId" id="homeworkId">
            {{--  TITULO  --}}
            <div class="form-group">
              <input type="text" class="form-control @error('modTitulo') is-invalid @enderror" id="modTitulo" name="modTitulo" placeholder="Titulo" value="{{ old('modTitulo') }}">
              @error('modTitulo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            {{--  BODY  --}}
            <div class="form-group">
              <textarea class="form-control tinyEditor @error('modBody') is-invalid @enderror" id="modBody" name="modBody" placeholder="Instrucciones" rows="8">{{ old('modBody') }}</textarea>
              @error('modBody')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            {{--  VLINK  --}}
            <div class="form-group">
              <input type="text" class="form-control" id="modVlink" name="modVlink" placeholder="Enlace" value="{{ old('modVlink') }}">
            </div>
            {{-- STUDENTS --}}
            <div class="form-group">
              <select class="form-control" name="modStudentId" id="modStudentId">
              </select>
            </div>
            {{-- FECHA DE ENTREGA --}}
            <div class="form-group">
              <small id="emailHelp" class="form-text text-muted">Fecha de Entrega</small>
              <input type="date" class="form-control" name="modEdate" id="modEdate" value="{{ old('modEdate') }}">
            </div>
            <button type="submit" class="btn btn-primary float-right">Modificar</button>
        </form>
        </div>
      </div>
    </div>
</div>

{{-- ERROR MODAL HANDLING --}}
@if ($errors->has('titulo'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#addTareaModal').modal('show'); });
  </script>
@endif

@if ($errors->has('body'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#addTareaModal').modal('show'); });
  </script>
@endif

@if ($errors->has('modTitulo'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#modTareaModal').modal('show'); });
  </script>
@endif

@if ($errors->has('modBody'))
  <script type="text/javascript">
    $( document ).ready(function() { $('#modTareaModal').modal('show'); });
  </script>
@endif