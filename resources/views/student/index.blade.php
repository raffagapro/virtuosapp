@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = []
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
      
        {{--  PROFILE PANEL  --}}
        <div class="col-md-3">
            <x-profile-panel :user="Auth::user()"/>
        </div>

        {{--  CLASSES PANEL  --}}
        <div class="col-md-9">
            <x-student.class-panel :user="Auth::user()"/>
        </div>
    </div>
</div>

@endsection
