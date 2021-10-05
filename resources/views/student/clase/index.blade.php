@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [$clase->label=>['studentDash.clase', $clase->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">

        {{--  HOMEWORK PANEL  --}}
        <div class="col-md-9">
            <x-student.homework-panel :user="Auth::user()" :clase="$clase"/>
        </div>
        
        {{-- TEACHER PROFILE PANEL --}}
        <div class="col-md-3">
            <x-student.teacher-profile-panel :user="Auth::user()" :clase="$clase"/>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/studenDashMessageMarker.js') }}" ></script>
@endsection
