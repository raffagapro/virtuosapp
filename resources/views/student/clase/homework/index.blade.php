@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [$homework->clase->label=>['studentDash.clase', $homework->clase->id], $homework->title=>['studentDash.tarea', $homework->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- MAIN PANEL --}}
        <div class="col-md-12">
            <div class="card border-secondary text-center">
                <div class="card-header">
                    <div class="my-3">
                        <h5>Instrucciones</h5>
                        <p>Docente: {{ $homework->clase->teacher()->name }}</p>
                    </div>
                </div>

                <div class="card-body px-5">
                    <p class="text-justify">{{ $homework->body }}</p>
                </div>

                <div class="card-footer px-5">
                    <div class="row">
                      @if (App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', Auth::user()->id)->first())
                        <div class="ml-auto mr-3">
                          <button class="btn btn-dark" data-toggle="modal" data-target="#uploadHomework">Reemplazar Tarea</button>
                        </div>
                        <div class="mr-3">
                          <a href="{{ asset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', Auth::user()->id)->first()->media) }}" class="btn btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Mi Tarea" download>
                            <i class="fas fa-book"></i>
                          </a>
                        </div>
                      @else
                        <div class="ml-auto mr-3">
                          <button class="btn btn-info text-white" data-toggle="modal" data-target="#uploadHomework">Subir Tarea</button>
                        </div>
                      @endif
                      @if ($homework->vlink !== null && $homework->vlink !== '')
                        <div class="mr-3">
                          <a href="{{ $homework->vlink }}" class="btn btn-danger text-white" target="_blank">Ver Video</a>
                        </div>
                      @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- RETRO --}}
        @if (App\Models\Retro::where('homework_id', $homework->id)->where('user_id', Auth::user()->id)->first())
          <div class="col-md-12 mt-4">
            <div class="card border-secondary text-center">
                <div class="card-header">
                  <div class="my-3">
                      <h5>Retroalimentacion</h5>
                  </div>
                </div>
                <div class="card-body px-5">
                  <p class="text-justify">{{ App\Models\Retro::where('homework_id', $homework->id)->where('user_id', Auth::user()->id)->first()->body }}</p>
                </div>
            </div>
          </div> 
        @endif

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
                            <a href="{{ asset($hm->media) }}" download>{{ str_replace('/storage/tHomework/', '', $hm->media) }}</a>
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
        
    </div>
</div>

<!-- Modal Agregar Student Homework -->
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
        <form id="retroFrom" action="{{ route('studentDash.ufile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="homeworkId" id="homeworkId" value="{{ $homework->id }}">
          <input type="hidden" name="studentId" id="studentId" value="{{ Auth::user()->id }}">
          {{--  FILE  --}}
          <div class="form-group">
            <input type="file" class="form-control-file @error('sFile') is-invalid @enderror" name="sFile">
            @error('sFile')
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


@if ($errors->any())
  <script type="text/javascript">
    $( document ).ready(function() { $('#uploadHomework').modal('show'); });
  </script>
@endif

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
{{-- @php
	dd($eStatus);
@endphp --}}
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
@endsection
