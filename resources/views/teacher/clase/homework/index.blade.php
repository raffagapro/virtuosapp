@extends('layouts.app')

@section('subBar')
  @php
    // dd($homework->clase->label);
    $crumbs = [$homework->clase->label=>['maestroDash.clase', $homework->clase->id], $homework->title=>['maestroDash.tarea', $homework->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
      {{-- MAIN PANEL --}}
      <div class="col-md-12">
          <div class="card border-secondary">
              <div class="card-header text-center">
                  <div class="my-3">
                      <h5>Instrucciones</h5>
                  </div>
              </div>

              <div class="card-body px-5">
                  <p class="">
                    {!! $homework->body !!}
                  </p>
              </div>

              <div class="card-footer px-5">
                  <div class="row">
                    @if ($homework->vlink !== null && $homework->vlink !== '')
                      <div class="ml-auto mr-3">
                        <a href="{{ $homework->vlink }}" class="btn btn-danger text-white" target="_blank">Ver Enlace</a>
                      </div>
                    @endif
                    <div class="mr-3">
                        <button class="btn btn-info text-white" data-toggle="modal" data-target="#uploadHomework">Subir Archivo</button>
                    </div>
                  </div>
              </div>
          </div>
      </div>
      
      {{-- FILES --}}
      @if (count($homework->medias) > 0)
        <div class="col-md-12 mt-4">
          <div class="card border-secondary text-center">
              <div class="card-header">
                <div class="my-3">
                    <h5>Archivos</h5>
                </div>
              </div>
              <div class="card-body px-5">
                <table class="table">
                  <tbody>
                    @forelse ($homework->medias as $hm)
                        <tr>
                          <td class="align-middle">
                            <a href="{{ asset($hm->media) }}" target="_blank">{{ str_replace('https://virtuousapp.s3.us-east-2.amazonaws.com/tHomework/', '', $hm->media) }}</a>
                            {{--  DELETE  --}}
                            <a
                              href="javascript:void(0);"
                              class="btn btn-sm btn-danger text-white mr-2"
                              data-toggle="tooltip" data-placement="top" title="Borrar"
                              onclick="
                                  event.preventDefault();
                                  swal.fire({
                                  text: '¿Deseas eliminar el archivo?',
                                  showCancelButton: true,
                                  cancelButtonText: `Cancelar`,
                                  cancelButtonColor:'#62A4C0',
                                  confirmButtonColor:'red',
                                  confirmButtonText:'Eliminar',
                                  icon:'error',
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('{{ 'delFile'.$hm->id }}').submit();
                                    }
                                  });"
                            >
                              <i class="far fa-trash-alt"></i>
                            </a>
                            <form id="{{ 'delFile'.$hm->id }}"
                              action="{{ route('maestroDash.dfile', $hm->id) }}"
                              method="POST"
                              style="display: none;"
                            >
                              @csrf
                              @method('DELETE')
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td class="align-middle">Sin archivos registrados</td>
                        </tr>
                      @endforelse
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      @endif

      {{-- ALUMNOS --}}
      <div class="col-md-12 mt-4">
        <div class="card border-secondary text-center">
            <div class="card-header">
              <div class="my-3">
                  <h5>Alumnos</h5>
              </div>
            </div>
            <div class="card-body px-5">
              <table class="table">
                <tbody>
                  @if ($homework->student > 0)
                    @php
                        $students = [$homework->getStudent()];
                    @endphp
                  @else
                    @php
                      $students = $homework->clase->students;
                    @endphp
                  @endif
                  @forelse ($students as $s)
                      <tr>
                        {{--  <td class="align-middle"><a href="{{ route('maestroDash.clase', $s->id) }}">{{ $s->name }}</a></td>  --}}
                        <td class="align-middle">{{ $s->name }}</td>
                        <td class="align-middle text-right py-0">
                          @php
                              $foundHomework = App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $s->id)->first();
                          @endphp
                          @if ($foundHomework)
                            @if ($foundHomework->status === 0 || $foundHomework->status === null)
                              <span class="badge btn-danger text-white">Pendiente</span> 
                            @endif
                            @if ($foundHomework->status === 1)
                              <span class="badge badge-info">Enviado</span>
                            @endif
                            @if ($foundHomework->status === 2)
                              <span class="badge badge-info">Completado</span>
                            @endif
                          @else
                            <span class="badge btn-danger text-white">Pendiente</span>
                          @endif
                          {{--  RETROALIMENTACION  --}}
                          <button id="{{ $s->id }}" class="btn retroBtn @if (!$homework->hasRetro($s->id)) btn-warning @else btn-primary @endif" data-toggle="modal" data-target="#retroMod">
                            <i class="fas @if (!$homework->hasRetro($s->id)) fa-chalkboard-teacher @else fa-check-double @endif" data-toggle="tooltip" data-placement="top" title="Retroalimentacion"></i>
                          </button>
                          {{-- STUDENT HOMEWORK --}}
                          @if (isset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $s->id)->first()->media))
                            <a href="{{ asset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $s->id)->first()->media) }}" class="btn btn-primary text-white" target="_blank">
                              <i class="fas fa-book" data-toggle="tooltip" data-placement="top" title="Tarea Alumno"></i>
                            </a>  
                          @endif
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
      </div>
  </div>
</div>

<!-- Modal Agregar Retro -->
<div class="modal fade" id="retroMod" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentNameCont"></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="retroFrom" action="{{ route('retro.update') }}" method="POST">
          @csrf
          <input type="hidden" name="homeworkId" id="homeworkId" value="{{ $homework->id }}">
          <input type="hidden" name="studentId" id="studentId">
          <input type="hidden" name="retroId" id="retroId">
          {{--  BODY  --}}
          <div class="form-group">
            <textarea class="form-control" id="body" name="body" placeholder="Retroalimentacion" rows="8"></textarea>
          </div>
          <button type="submit" class="btn btn-primary float-right">Guardar</button>
      </form>
      </div>
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
        <form id="retroFrom" action="{{ route('maestroDash.ufile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="homeworkId" id="homeworkId" value="{{ $homework->id }}">
          {{--  FILE  --}}
          <div class="form-group">
            <input type="file" class="form-control-file @error('hFile') is-invalid @enderror" name="hFile">
            <small>Limite de 2MB. Extensiones: jpeg, png, pdf, doc, ppt, pptx, xlx, xlsx, docx, zip</small>
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
