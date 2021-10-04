<div class="card border-secondary">
    <div class="card-header text-center">
        <div class="my-3">
            <h5>Instrucciones</h5>
            @if ($user->role->name == "Estudiante")
                <p>Docente: {{ $homework->clase->teacher()->name }}</p>
            @endif
        </div>
    </div>

    <div class="card-body px-5">
        <p class="">
            {!! $homework->body !!}
        </p>
    </div>

    <div class="card-footer px-5">
        <div class="row">
            {{-- HOMEWORK FILE --}}
            @if ($homework->vlink !== null && $homework->vlink !== '')
                <div class="ml-auto mr-3">
                    <a href="{{ $homework->vlink }}" class="btn btn-danger text-white" target="_blank">Ver Enlace</a>
                </div>
            @endif

            {{-- UPLOAD FILE --}}
            @if ($user->role->name == "Estudiante")
                {{-- IF THE STUDENT HOMEWORK HAS A FILE --}}
                @if ($uploadFileBtnGo)
                    <div class="mr-3">
                        <a href="{{ asset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $user->id)->first()->media) }}" class="btn btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Mi Tarea" target="_blank">
                            <i class="fas fa-book"></i>
                        </a>
                    </div>  
                @endif
                {{-- MARK COMPLETE BTN --}}
                @if ($markCompleteBtnGo)
                    <div class="mr-3">
                        <a href="{{ route('studentDash.done', [$homework->id, $user->id]) }}" class="btn btn-dark text-white @if (Auth::user()->role->name !== "Estudiante") disabled @endif" data-toggle="tooltip" data-placement="top" title="Marcar Completada">
                            <i class="fas fa-check"></i>
                        </a>
                    </div>  
                @endif
            @else
                
            @endif
            {{-- UPLOAD FILE BTN --}}
            @if (!$uploadFileBtnGo)
                <div class="mr-3">
                    <button class="btn btn-info text-white" data-toggle="modal" data-target="#uploadHomework" @if (Auth::user()->role->name !== "Estudiante" && $user->role->name === "Estudiante") disabled @endif>
                        Subir Archivo
                    </button>
                </div>
            @else
                <div class="mr-3">
                    <button class="btn btn-dark" data-toggle="modal" data-target="#uploadHomework" @if (Auth::user()->role->name !== "Estudiante") disabled @endif>
                        Reemplazar Archivo
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Agregar Homework File -->
<div class="modal fade" id="uploadHomework" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Tarea</h5>
                <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (!$monitor)
                    @if ($user->role->name === "Estudiante")
                        <form id="retroFrom" action="{{ route('studentDash.ufile') }}" method="POST" enctype="multipart/form-data">
                    @else   
                        <form id="retroFrom" action="{{ route('maestroDash.ufile') }}" method="POST" enctype="multipart/form-data">
                    @endif
                @else
                    @if ($user->role->name === "Coordinador")
                        <form id="retroFrom" action="{{ route('monitor.ufile') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form id="retroFrom" action="{{ route('admin.monitorTeacherUfile') }}" method="POST" enctype="multipart/form-data">
                    @endif
                @endif
                    @csrf
                    <input type="hidden" name="homeworkId" id="homeworkId" value="{{ $homework->id }}">
                    @if ($user->role->name === "Estudiante")
                        <input type="hidden" name="studentId" id="studentId" value="{{ $user->id }}">
                    @endif
                    {{--  FILE  --}}
                    <div class="form-group">
                        <input type="file" class="form-control-file @error('hFile') is-invalid @enderror" name="hFile">
                        <small>Limite de 4MB. Extensiones: jpeg, png, pdf, doc, ppt, pptx, xlx, xlsx, docx, zip</small>
                        @error('hFile')
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