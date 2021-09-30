<div class="card border-secondary">
    <div class="card-body">
        <table class="table">
            <thead>
              <tr>
                <th><h5>Clases</h5></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @forelse (App\Models\Clase::where('teacher', $user->id)->where('status', '1')->orderBy('label')->get() as $c)
                    <tr>
                        {{--  NAME  --}}
                        <td class="align-middle">
                            @if ($monitor)
                                @if (Auth::user()->role->name === "Coordinador")
                                    <a href="{{ route('monitor.clase', $c->id) }}">{{ $c->label }}</a>
                                @else
                                    <a href="{{ route('admin.teacherClaseMonitor', $c->id) }}">{{ $c->label }}</a>   
                                @endif    
                            @else
                                <a href="{{ route('maestroDash.clase', $c->id) }}">{{ $c->label }}</a>
                            @endif
                        </td>
                        <td class="align-middle text-right py-0">
                            <button type="button" class="btn btn-link zoomModalBtn" id="{{ $c->id }}" data-toggle="modal" data-target="#zoomModal">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
                                </span>
                            </button>
                        </td>
                      </tr>
                @empty
                    <tr>
                        <td class="align-middle">Sin clases registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Zoom Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Zoom - <span id="classNameCont"></span></h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
            @if ($monitor)
                @if (Auth::user()->role->name === "Coordinador")
                    <form action="{{ route('monitor.setZlink') }}" method="POST">
                @else           
                    <form action="{{ route('admin.monitorSetZlink') }}" method="POST">
                @endif  
            @else
                <form action="{{ route('clase.setZlink') }}" method="POST">
            @endif
			@csrf
			<input type="hidden" id="claseID" name="claseID">
			{{--  LINK  --}}
			<div class="form-group">
			  <input type="text" class="form-control" id="zlink" name="zlink" placeholder="LINK">
			</div>
			<button type="submit" class="btn btn-primary float-right">Guardar</button>
			<a href="javascript:void(0);" class="btn btn-danger float-right mr-1" id="zoomBtn" target="_blank">
				<i class="fas fa-video" data-toggle="tooltip" data-placement="top" title="Abrir Zoom"></i>
			</a>
		</form>
		</div>
	  </div>
	</div>
</div>