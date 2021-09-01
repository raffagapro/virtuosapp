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
      <div class="col-md-12">
          <div class="card border-secondary text-center">
              <div class="card-header">
                  <div class="my-3">
                      <h5>Instrucciones</h5>
                  </div>
              </div>

              <div class="card-body px-5">
                  <p class="text-justify">
                    {{ $homework->body }}
                  </p>
              </div>

              <div class="card-footer px-5">
                  <div class="row">
                    @if ($homework->vlink !== null && $homework->vlink !== '')
                      <div class="ml-auto mr-3">
                        <a href="{{ $homework->vlink }}" class="btn btn-danger text-white" target="_blank">Ver Video</a>
                      </div>
                    @endif
                  </div>
              </div>
          </div>
      </div>

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
                          {{--  <button class="btn btn-warning text-white disabled">Nuevo</button>  --}}
                          <button class="btn btn-info">Completado</button>
                          {{--  <button class="btn btn-danger text-white">Pendiente</button>  --}}

                          {{--  RETROALIMENTACION  --}}
                          <button id="{{ $s->id }}" class="btn retroBtn @if (!$homework->hasRetro($s->id)) btn-warning @else btn-primary @endif" data-toggle="modal" data-target="#retroMod">
                            <i class="fas @if (!$homework->hasRetro($s->id)) fa-chalkboard-teacher @else fa-check-double @endif" data-toggle="tooltip" data-placement="top" title="Retroalimentacion"></i>
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
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherDashHomeworkSwitcher.js') }}" ></script>
@endsection