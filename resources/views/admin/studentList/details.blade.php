@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Estudiantes"=>['estudiantes.index'], $student->name => ['estudiantes.edit', $student->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-2">
              <span class="fa-stack fa-4x">
                @if ($student->perfil)
                  <img src="{{ asset($student->perfil) }}" class="chat-img">	
                @else
                  <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                  <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                @endif
              </span>
            </div>
            <div class="col-10 text-left pl-0">
              <h4>{{ $student->name }}</h4>
              <h4>{{ $student->username }}</h4>
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-5">
                      {{-- EDAD --}}
                      @if (isset($student->edad))
                        <p>{{ $student->edad }} Años</p>
                      @else
                        <p class="text-danger">Edad sin asignar</p> 
                      @endif
                      {{-- GRADO --}}
                      @if (isset($student->grado))
                        <p>{{ $student->grado->name }}</p>
                      @else
                        <p class="text-danger">Grado sin asignar</p> 
                      @endif
                    </div>
                    <div class="col-7 pl-0">
                      {{-- CURP --}}
                      @if (isset($student->curp))
                      <p>{{ strtoupper($student->curp) }}</p>
                      @else
                        <p class="text-danger">CURP sin asignar</p> 
                      @endif
                      {{-- MODALIDAD --}}
                      @if (isset($student->modalidad))
                        <p>{{ $student->modalidad->name }}</p>
                      @else
                        <p class="text-danger">Modalidad sin asignar</p> 
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-6 text-left pl-0">
                      {{-- TUTOR1 --}}
                      @if (isset($student->tutor1))
                        <p>
                          Tutor 1 : {{ strtoupper($student->getTutor($student->tutor1)->name) }}
                          <a href="{{ route('estudiantes.rmTutor', [$student->getTutor($student->tutor1)->id, $student->id, 1]) }}">
                            <i class="fas fa-times text-danger" data-toggle="tooltip" data-placement="top" title="Remover Tutor"></i>
                          </a>
                        </p>
                      @else
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#addTutorModal" id="tutor-1" class="addTutorBtn">
                          <p class="text-danger">Tutor 1 : Sin asignar</p>
                        </a>
                      @endif
                      {{-- TUTOR2 --}}
                      @if (isset($student->tutor2))
                        <p>
                          Tutor 2 : {{ strtoupper($student->getTutor($student->tutor2)->name) }}
                          <a href="{{ route('estudiantes.rmTutor', [$student->getTutor($student->tutor2)->id, $student->id, 2]) }}">
                            <i class="fas fa-times text-danger" data-toggle="tooltip" data-placement="top" title="Remover Tutor"></i>
                          </a>
                        </p>
                      @else
                      <a href="javascript:void(0);" data-toggle="modal" data-target="#addTutorModal" id="tutor-2" class="addTutorBtn">
                        <p class="text-danger">Tutor 2 : Sin asignar</p>
                      </a>
                        @endif
                    </div>
                    <div class="col-6 text-right pl-0">
                      {{--  MODIFY STUDENT BTN  --}}
                      <button class="btn btn-primary" data-toggle="modal" data-target="#modStudentModal">
                        <i class="fas fa-pen fa-fw" data-toggle="tooltip" data-placement="top" title="Modificar Estudiante"></i>
                      </button>
                      {{--  ADD CLASS BTN  --}}
                      <button class="btn btn-info" data-toggle="modal" data-target="#addClaseModal">
                        <i class="fas fa-plus fa-fw" data-toggle="tooltip" data-placement="top" title="Agregar Clase"></i>
                      </button>
                      {{--  DELETE STUDENT BTN  --}}
                      <a
                        href="javascript:void(0);"
                        data-toggle="tooltip" data-placement="top" title="Eliminar Estudiante"
                        class="btn btn-danger"
                        onclick="
                          event.preventDefault();
                          swal.fire({
                            text: '¿Deseas eliminar al estudiante?',
                            showCancelButton: true,
                            cancelButtonText: `Cancelar`,
                            cancelButtonColor:'#62A4C0',
                            confirmButtonColor:'red',
                            confirmButtonText:'Eliminar',
                            icon:'error',
                          }).then((result) => {
                            if (result.isConfirmed) {
                              document.getElementById('{{ 'delStudent'.$student->id }}').submit();
                            }
                          });"
                      >
                        <i class="fas fa-trash-alt fa-fw"></i>
                      </a>
                      <form id="{{ 'delStudent'.$student->id }}"
                        action="{{ route('estudiantes.destroy', $student->id) }}"
                        method="POST"
                        style="display: none;"
                      >@csrf @method('DELETE')
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#activas"><h4>Clases Activas</h4>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#cerradas"><h4>Clases Cerradas</h4></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="tab-content">
            {{-- TAB ABIERTAS --}}
            <div class="tab-pane active" id="activas">
              @include('admin.studentList.activas')
            </div>
            {{-- TAB CERRADAS --}}
            <div class="tab-pane" id="cerradas">
              @include('admin.studentList.cerradas')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modify Student -->
<div class="modal fade" id="modStudentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Estudiante</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('estudiantes.update', $student->id) }}" method="POST">
          @csrf
          @method('PUT')
          {{--  NOMBRE  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modNombre') is-invalid @enderror" name="modNombre" value="{{ $student->name }}" placeholder="Nombre">
            @error('modNombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
          </div>
          {{--  USUARIO  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modUserName') is-invalid @enderror" name="modUserName" value="{{ $student->username }}" placeholder="Usuario">
            @error('modUserName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  Email  --}}
          <div class="form-group">
            <input type="mail" class="form-control @error('modEmail') is-invalid @enderror" name="modEmail" value="{{ $student->email }}" placeholder="Correo">
            @error('modEmail')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  CURP  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modCurp') is-invalid @enderror" name="modCurp" value="{{ $student->curp }}" placeholder="CURP">
            @error('modCurp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{-- EDAD / GRADO --}}
          <div class="form-group row">
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Edad</small>
              <input type="number" min="1" max="99" class="form-control @error('modAge') is-invalid @enderror" name="modAge" value="{{ $student->edad }}" placeholder="Edad">
              @error('modAge')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Grado</small>
              <select class="form-control" name="modGradoId">
                <option value=0>Sin Grado</option>
                @forelse (App\Models\Grado::all() as $g)
                  @if (isset($student->grado))
                    @if ($g->id === $student->grado->id)
                      <option value={{ $g->id }} selected>{{ $g->name }}</option>
                    @else
                      <option value={{ $g->id }}>{{ $g->name }}</option>
                    @endif
                  @else
                    <option value={{ $g->id }}>{{ $g->name }}</option>
                  @endif
                @empty
                    <option value=0 disabled>No hay grados registrados</option>
                @endforelse
              </select>
            </div>
          </div>
          {{--  MODALIDAD  --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Modalidad</small>
              <select class="form-control" name="modModalidadId">
                <option value=0>Sin Modalidad</option>
                @forelse (App\Models\Modalidad::all() as $m)
                @if (isset($student->modalidad))
                  @if ($m->id === $student->modalidad->id)
                    <option value={{ $m->id }} selected>{{ $m->name }}</option> 
                  @else
                    <option value={{ $m->id }}>{{ $m->name }}</option>
                  @endif
                @else
                  <option value={{ $m->id }}>{{ $m->name }}</option>
                @endif
                @empty
                    <option value=0 disabled>No hay modalidades registradas</option>
                @endforelse
              </select>
          </div>
          <button type="submit" class="btn btn-primary float-right">Modificar</button>
          <a href="{{ route('user.resetPW', $student->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Password</a>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Tutor -->
<div class="modal fade" id="addTutorModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Agregar Tutor <span id="tutorNumCont"></span></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="tutorSearch" placeholder="Nombre del tutor">
          <input type="hidden" id="studentId" value="{{ $student->id }}">
          <input type="hidden" id="tutorNum">
        </div>
        <table class="table table-bordered">
          <tbody id="tutorListCont">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Clase -->
<div class="modal fade" id="addClaseModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Agregar Clase</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="classSearch" placeholder="Nombre de la clase">
          <input type="hidden" id="studentId" value="{{ $student->id }}">
        </div>
        <table class="table table-bordered">
          <tbody id="classListCont">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@if ($errors->any())
  <script type="text/javascript">
    $( document ).ready(function() { $('#modStudentModal').modal('show'); });
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
<script src="{{ asset('js/ajax/studentIndvSwitcher.js') }}" ></script>
@endsection
