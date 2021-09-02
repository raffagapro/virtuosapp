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
        <div class="col-md-12">
            <div class="card border-secondary text-center">
                <div class="card-header">
                    <div class="my-3">
                        <h5>Instrucciones</h5>
                    </div>
                </div>

                <div class="card-body px-5">
                    <p class="text-justify">{{ $homework->body }}</p>
                </div>

                <div class="card-footer px-5">
                    <div class="row">
                        <div class="ml-auto mr-3">
                            <button class="btn btn-info text-white">Subir Tarea</button>
                        </div>
                        @if ($homework->vlink !== null && $homework->vlink !== '')
                          <div class="mr-3">
                            <a href="{{ $homework->vlink }}" class="btn btn-danger text-white" target="_blank">Ver Video</a>
                          </div>
                        @endif
                        <div class="mr-3">
                            <button class="btn btn-dark text-white"><i class="fas fa-book"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="materiasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
