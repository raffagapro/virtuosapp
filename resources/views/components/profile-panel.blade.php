<div class="card bgVirtuos border-secondary text-light text-center py-5">
    <div class="card-body">
      <div class="mx-auto mb-3">
          @if (!$monitor)
              <a href="javascript:void(0);" data-toggle="modal" data-target="#uploadProfile"> 
          @endif
          <span class="fa-stack fa-5x">
              @if ($user->perfil)
              <img src="{{ asset($user->perfil) }}" class="chat-img">	
              @else
              <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
              <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
              @endif
          </span>
          @if (!$monitor)</a>@endif
      </div>
      {{--  PROFILE NAME  --}}
      @if (($user->role->name === "Maestro" || $user->role->name === "Coordinador") && !$monitor)
          <h3 class="mb-0" data-toggle="modal" data-target="#modTeacherModal"><a class="text-white-50" href="javascript:void(0);">{{ $user->name }}</a></h3>
      @else
          <h3 class="mb-0">{{ $user->name }}</h3>
      @endif
      {{--  GRADO/AREA  --}}
      @if ($user->role->name === "Estudiante")
        @if (isset($user->grado))
            <p class="text-white-50">{{ $user->grado->name }}</p>
        @else
            <p class="text-white-50">Sin Grado asignado</p>	
        @endif
      @elseif ($user->role->name === "Maestro" || $user->role->name === "Coordinador")
        @if (isset($user->area))
            <p class="text-white-50">{{ $user->area->name }}</p>
        @else
            <p class="text-white-50">Sin Area asignada</p>	
        @endif
      @else
        {{--  PRINT NOTHING  --}}
      @endif
      {{--  PASSWORD  --}}
      @if (!$monitor)
          <p>
              <a href="javascript:void(0);" class="text-white-50" data-toggle="modal" data-target="#passwordModal">Modificar Contraseña</a>
          </p>
          @if ($user->role->name === "Maestro")
              {{--  MESSAGE BTN  --}}
              <a href="javascript:void(0);" type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#newChatModal">
                  <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="Nuevo Mensaje">
                      <i class="fas fa-circle fa-stack-2x text-light"></i>
                      <i class="fas fa-comments fa-stack-1x fa-inverse text-primary"></i>
                  </span>
              </a>
          @endif
      @endif
    </div>
</div>

@if (!$monitor)
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
            @if ($user->role->name === "Maestro")
              <form action="{{ route('maestro.updatePW', $user->id) }}" method="POST">
            @elseif ($user->role->name === "Coordinador")
              <form action="{{ route('coordinatorDash.updatePW', $user->id) }}" method="POST">          
            @else    
		          <form action="{{ route('student.updatePW', $user->id) }}" method="POST">
            @endif
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
                <a href="{{ route('user.resetPW', $user->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Contraseña</a>
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
        @if ($user->role->name === "Maestro")
          <form id="retroFrom" action="{{ route('maestroDash.profile') }}" method="POST" enctype="multipart/form-data">
        @elseif ($user->role->name === "Coordinador")
          <form id="retroFrom" action="{{ route('coordinatorDash.profile') }}" method="POST" enctype="multipart/form-data">              
        @else    
          <form id="retroFrom" action="{{ route('studentDash.profile') }}" method="POST" enctype="multipart/form-data">
        @endif
          @csrf
          <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
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

<!-- Modal Modify Teacher -->
<div class="modal fade" id="modTeacherModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Modificar Informacion</h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
      @if ($user->role->name === "Maestro")
        <form action="{{ route('maestro.updateInfo', $user->id) }}" method="POST">     
      @else
        <form action="{{ route('coordinatorDash.updateInfo', $user->id) }}" method="POST">    
      @endif
			@csrf
			@method('PUT')
			{{--  NOMBRE  --}}
			<div class="form-group">
			  <input type="text" class="form-control" name="modNombre" placeholder="Nombre" value="{{ $user->name }}">
			</div>
			{{--  USERNAME  --}}
			<div class="form-group">
				<input type="text" class="form-control" name="modUserName" placeholder="Usuario" value="{{ $user->username }}">
			  </div>
			{{--  Email  --}}
			<div class="form-group">
			  <input type="mail" class="form-control" name="modEmail" placeholder="Correo" value="{{ $user->email }}">
			</div>
			{{--  CURP  --}}
			<div class="form-group">
			  <input type="text" class="form-control" name="modCurp" placeholder="CURP" value="{{ $user->curp }}">
			</div>
			<button type="submit" class="btn btn-primary float-right">Modificar</button>
		</form>
		</div>
	  </div>
	</div>
</div>

@if ($user->role->name === "Maestro")
<!-- Modal New Chat -->
<div class="modal fade" id="newChatModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="modTitleCont">Nuevo Chat</h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <div class="form-group">
			<input type="text" class="form-control" id="studentSearch" placeholder="Nombre del estudiante">
		  </div>
		  <table class="table table-bordered">
			<tbody id="stidentListCont">
			</tbody>
		  </table>
		</div>
	  </div>
	</div>
</div>
@endif

@error('nuevaContraseña')
	<script type="text/javascript">
		$( document ).ready(function() {
		$('#passwordModal').modal('show');
	});
	</script>
@enderror
@endif