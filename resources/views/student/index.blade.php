@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = []
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                  <div class="mx-auto mb-3">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#uploadProfile">
                      <span class="fa-stack fa-5x">
                        @if (Auth::user()->perfil)
                          <img src="{{ asset(Auth::user()->perfil) }}" class="chat-img">	
                        @else
                          <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                          <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                        @endif
                      </span>
                    </a>
                  </div>
                  <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                  @if (isset(Auth::user()->grado))
                    <p class="text-white-50">{{ Auth::user()->grado->name }}</p>
                  @else
                    <p class="text-white-50">Sin Grado asignado</p>	
                  @endif
                  <p>
                    <a href="javascript:void(0);" class="text-white-50" data-toggle="modal" data-target="#passwordModal">Modificar Contraseña</a>
                  </p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-secondary px-3">
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="col-9 text-left"><h5>Clases</h4></th>
                            <th class="col-3"><h5>Status</h4></th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse (Auth::user()->clases as $c)
                            <tr>
                              <td class="text-left">
                                <a href="{{ route('studentDash.clase', $c->id) }}">{{ $c->label }}</a>
                                {{--  ZOOM BTN  --}}
                                {{--  <a href="{{ $c->zlink }}" type="button" class="btn btn-link p-0 @if ($c->zlink === null) disabled @endif" target="_blank" data-toggle="tooltip" data-placement="top" title="Clase Zoom">
                                  <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
                                  </span>
                                </a>  --}}
                              </td>
                              @php
                                  $hws = $c->homeworks->all();
                                  $pendingHomeworks = false;
                                  foreach ($hws as $thw) {
                                    if ($thw->student === 0 || $thw->student === Auth::user()->id) {
                                      if (!App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', Auth::user()->id)->first()) {
                                        $pendingHomeworks = true;
                                      }else {
                                        if (App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', Auth::user()->id)->first()->status !== 2) {
                                          $pendingHomeworks = true;
                                        }
                                      }
                                    }
                                  }
                              @endphp
                              <td>
                                @if ($pendingHomeworks)
                                  <span class="badge bg-danger tarea-status">Pendiente</span> 
                                @else
                                  <span class="badge bg-info tarea-status">Complete</span>
                                @endif
                              </td>
                            </tr>
                          @empty
                              
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Cambiar Contraseña</h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('student.updatePW', Auth::user()->id) }}" method="POST">
			@csrf
			@method('PUT')
			{{--  CURRENT PASSWORD  --}}
			<div class="form-group">
			  <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña">
			</div>
			<div class="form-group">
				<input type="password" class="form-control @error('nuevaContraseña') is-invalid @enderror" id="nuevaContraseña" name="nuevaContraseña" placeholder="Nueva Contraseña">
				@error('nuevaContraseña')
					<span class="invalid-feedback" role="alert">
						{{--  <strong>{{ $message }}</strong>  --}}
						<strong>La nueva contraseña es invalida o no concuerda</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="nuevaContraseña_confirmation" name="nuevaContraseña_confirmation" placeholder="Confirmar Nueva Contraseña">
			</div>
			<button type="submit" class="btn btn-primary float-right">Modificar</button>
			<a href="{{ route('user.resetPW', Auth::user()->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Contraseña</a>
		</form>
		</div>
	  </div>
	</div>
</div>

<!-- Modal Image Profile -->
<div class="modal fade" id="uploadProfile" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Foto de Perfil</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="retroFrom" action="{{ route('studentDash.profile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->id }}">
          {{--  FILE  --}}
          <div class="form-group">
            <input type="file" class="form-control-file @error('photoFile') is-invalid @enderror" name="photoFile">
            @error('photoFile')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary float-right">Guardar</button>
      </form>
      </div>
    </div>
  </div>
</div>

{{--  ALERTS  --}}
@if(session('status'))
	@if (session('eStatus') === null)
		<x-success-alert :message="session('status')"/>
	@else
		@if (session('eStatus') === 1)
			<x-success-alert :message="session('status')"/>
		@else
			<x-error-alert :message="session('status')"/>	
		@endif
	@endif
@endif
@isset($status)
	@if ($eStatus === null)
		<x-success-alert :message="$status"/>
	@else
		@if ($eStatus)
			<x-success-alert :message="$status"/>
		@else
			<x-error-alert :message="$status"/>
		@endif
	@endif
@endisset

@error('nuevaContraseña')
	<script type="text/javascript">
		$( document ).ready(function() {
		$('#passwordModal').modal('show');
	});
	</script>
@enderror
@endsection
