@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Tutores"=>['tutores.index'], $tutor->name => ['tutores.edit', $tutor->id]]
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
              <img class="studentPortrait" src="" alt="">
            </div>
            <div class="col-10 text-left pl-0">
              <h4>{{ $tutor->name }}</h4>
              <div class="row">
                <div class="col-9">
                  <div class="row">
                    <div class="col-5">
                      {{-- UserName --}}
                      @if (isset($tutor->username))
                        <p>{{ $tutor->username }}</p>
                      @else
                        <p class="text-danger">Usuario sin asignar</p> 
                      @endif
                      {{-- Email --}}
                      @if (isset($tutor->email))
                      <p>{{ $tutor->email }}</p>
                      @else
                        <p class="text-danger">Email sin asignar</p> 
                      @endif
                    </div>
                    <div class="col-7 pl-0">
                      {{-- CURP --}}
                      @if (isset($tutor->curp))
                      <p>{{ strtoupper($tutor->curp) }}</p>
                      @else
                        <p class="text-danger">CURP sin asignar</p> 
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="row">
                    <div class="col text-right pl-0">
                      {{--  MODIFY TUTOR BTN  --}}
                      <button class="btn btn-primary" data-toggle="modal" data-target="#modTutorModal">
                        <i class="fas fa-pen fa-fw" data-toggle="tooltip" data-placement="top" title="Modificar Maestro"></i>
                      </button>
                      {{--  ADD CLASS BTN  --}}
                      <button class="btn btn-info" data-toggle="modal" data-target="#addClaseModal">
                        <i class="fas fa-plus fa-fw" data-toggle="tooltip" data-placement="top" title="Agregar Clase"></i>
                      </button>
                      {{--  DELETE STUDENT BTN  --}}
                      <a
                        href="javascript:void(0);"
                        data-toggle="tooltip" data-placement="top" title="Eliminar Maestro"
                        class="btn btn-danger"
                        onclick="
                          event.preventDefault();
                          swal.fire({
                            text: '¿Deseas eliminar al maestro?',
                            showCancelButton: true,
                            cancelButtonText: `Cancelar`,
                            cancelButtonColor:'#62A4C0',
                            confirmButtonColor:'red',
                            confirmButtonText:'Eliminar',
                            icon:'error',
                          }).then((result) => {
                            if (result.isConfirmed) {
                              document.getElementById('{{ 'delTutor'.$tutor->id }}').submit();
                            }
                          });"
                      >
                        <i class="fas fa-trash-alt fa-fw"></i>
                      </a>
                      <form id="{{ 'delTutor'.$tutor->id }}"
                        action="{{ route('maestros.destroy', $tutor->id) }}"
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
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modify Tutor -->
<div class="modal fade" id="modTutorModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Maestro</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('maestros.update', $tutor->id) }}" method="POST">
          @csrf
          @method('PUT')
          {{--  NOMBRE  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modNombre') is-invalid @enderror" name="modNombre" value="{{ $tutor->name }}" placeholder="Nombre">
            @error('modNombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  USUARIO  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modUserName') is-invalid @enderror" name="modUserName" value="{{ $tutor->username }}" placeholder="Usuario">
            @error('modUserName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  Email  --}}
          <div class="form-group">
            <input type="mail" class="form-control @error('modEmail') is-invalid @enderror" name="modEmail" value="{{ $tutor->email }}" placeholder="Correo">
            @error('modEmail')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  CURP  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modCurp') is-invalid @enderror" name="modCurp" value="{{ $tutor->curp }}" placeholder="CURP">
            @error('modCurp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary float-right">Modificar</button>
          <a href="{{ route('user.resetPW', $tutor->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Password</a>
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
          <input type="hidden" id="tutorId" value="{{ $tutor->id }}">
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
    $( document ).ready(function() { $('#modTutorModal').modal('show'); });
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
<script src="{{ asset('js/ajax/teacherIndvSwitcher.js') }}" ></script>
@endsection
