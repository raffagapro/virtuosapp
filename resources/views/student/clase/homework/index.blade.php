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
          <x-homework.main-panel :user="Auth::user()" :homework="$homework"/>
        </div>

        {{-- RETRO --}}
        @if (App\Models\Retro::where('homework_id', $homework->id)->where('user_id', Auth::user()->id)->first())
          <x-homework.retro-panel :user="Auth::user()" :homework="$homework"/> 
        @endif

        {{-- FILES --}}
        @if (count($homework->medias) > 0)
          <div class="col-md-12 mt-4">
            <x-homework.teacher-files-panel :user="Auth::user()" :homework="$homework"/>
          </div>
        @endif
        
    </div>
</div>

@endsection
