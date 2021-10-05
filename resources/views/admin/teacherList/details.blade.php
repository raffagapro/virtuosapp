@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Maestros"=>['maestros.index'], $teacher->name => ['maestros.edit', $teacher->id]]
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
                @if ($teacher->perfil)
                  <img src="{{ asset($teacher->perfil) }}" class="chat-img">	
                @else
                  <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                  <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                @endif
              </span>
            </div>
            <div class="col-10 text-left pl-0">
              <h4>{{ $teacher->name }}</h4>
              <div class="row">
                <div class="col-9">
                  <div class="row">
                    <div class="col-5">
                      {{-- Area --}}
                      @if (isset($teacher->area))
                        <p>{{ $teacher->area->name }}</p>
                      @else
                        <p class="text-danger">Area sin asignar</p> 
                      @endif
                      {{-- UserName --}}
                      @if (isset($teacher->username))
                        <p>{{ $teacher->username }}</p>
                      @else
                        <p class="text-danger">Usuario sin asignar</p> 
                      @endif
                      {{-- Email --}}
                      @if (isset($teacher->email))
                      <p>{{ $teacher->email }}</p>
                      @else
                        <p class="text-danger">Email sin asignar</p> 
                      @endif
                    </div>
                    <div class="col-7 pl-0">
                      {{-- CURP --}}
                      @if (isset($teacher->curp))
                      <p>{{ strtoupper($teacher->curp) }}</p>
                      @else
                        <p class="text-danger">CURP sin asignar</p> 
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="row">
                    <div class="col text-right pl-0">
                      {{--  MODIFY TEACHER BTN  --}}
                      <button class="btn btn-primary" data-toggle="modal" data-target="#modTeacherModal">
                        <i class="fas fa-pen fa-fw" data-toggle="tooltip" data-placement="top" title="Modificar Maestro"></i>
                      </button>
                      {{--  ADD CLASS BTN  --}}
                      <button class="btn btn-info" data-toggle="modal" data-target="#addClaseModal">
                        <i class="fas fa-plus fa-fw" data-toggle="tooltip" data-placement="top" title="Agregar Clase"></i>
                      </button>
                      {{--  DELETE STUDENT BTN  --}}
                      <x-delete-btn
                        :tooltip="'Eliminar Maestro'"
                        :id="[$teacher->id]"
                        :text="'¿Deseas eliminar al maestro?'"
                        :elemName="'delTeacher'"
                        :routeName="'maestros.destroy'"
                      />
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
              @include('admin.teacherList.activas')
            </div>
            {{-- TAB CERRADAS --}}
            <div class="tab-pane" id="cerradas">
              @include('admin.teacherList.cerradas')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modify Teacher -->
<div class="modal fade" id="modTeacherModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Maestro</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('maestros.update', $teacher->id) }}" method="POST">
          @csrf
          @method('PUT')
          {{--  NOMBRE  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modNombre') is-invalid @enderror" name="modNombre" value="{{ $teacher->name }}" placeholder="Nombre">
            @error('modNombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  USUARIO  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modUserName') is-invalid @enderror" name="modUserName" value="{{ $teacher->username }}" placeholder="Usuario">
            @error('modUserName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  Email  --}}
          <div class="form-group">
            <input type="mail" class="form-control @error('modEmail') is-invalid @enderror" name="modEmail" value="{{ $teacher->email }}" placeholder="Correo">
            @error('modEmail')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  CURP  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modCurp') is-invalid @enderror" name="modCurp" value="{{ $teacher->curp }}" placeholder="CURP">
            @error('modCurp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  AREA  --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Area</small>
              <select class="form-control" name="modAreaId">
                <option value=0>Sin Area</option>
                @forelse (App\Models\Area::all() as $a)
                @if (isset($teacher->area))
                  @if ($a->id === $teacher->area->id)
                    <option value={{ $a->id }} selected>{{ $a->name }}</option> 
                  @else
                    <option value={{ $a->id }}>{{ $a->name }}</option>
                  @endif
                @else
                  <option value={{ $a->id }}>{{ $a->name }}</option>
                @endif
                @empty
                    <option value=0 disabled>No hay areas registradas</option>
                @endforelse
              </select>
          </div>

          <button type="submit" class="btn btn-primary float-right">Modificar</button>
          <a href="{{ route('user.resetPW', $teacher->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Password</a>
      </form>
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
          <input type="hidden" id="teacherId" value="{{ $teacher->id }}">
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
    $( document ).ready(function() { $('#modTeacherModal').modal('show'); });
  </script>
@endif
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherIndvSwitcher.js') }}" ></script>
@endsection
