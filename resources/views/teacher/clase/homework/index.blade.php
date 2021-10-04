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
        <x-homework.main-panel :user="Auth::user()" :homework="$homework"/>
      </div>
      
      {{-- FILES --}}
      @if (count($homework->medias) > 0)
        <div class="col-md-12 mt-4">
          <x-homework.teacher-files-panel :user="Auth::user()" :homework="$homework"/>
        </div>
      @endif

      {{-- ALUMNOS --}}
      <div class="col-md-12 mt-4">
        <x-homework.student-panel :homework="$homework"/>
      </div>
  </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherDashHomeworkSwitcher.js') }}" ></script>
@endsection