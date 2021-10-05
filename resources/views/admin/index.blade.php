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

      {{--  LEFT PROFILE PANEL  --}}
      <div class="col-md-3">
        <x-profile-panel :user="Auth::user()"/>
      </div>

      {{-- SECTIONS BTNS --}}
      <div class="col-md-8">
          <div class="row mb-4">
            <x-admin-btn :title="'Estudiantes'" :iconURL="'assets\images\student_icon.png'" :routex="'estudiantes.index'"/>
            <x-admin-btn :title="'Materias'" :iconURL="'assets\images\classes_icon.png'" :routex="'materias.index'"/>
          </div>
          <div class="row my-4">
            <x-admin-btn :title="'Maestros'" :iconURL="'assets\images\teacher_icon.png'" :routex="'maestros.index'"/>
            <x-admin-btn :title="'Coordinadores'" :iconURL="'assets\images\staff_icon.png'" :routex="'coordinator.index'"/>
          </div>
          <div class="row mb-4">
            <x-admin-btn :title="'Tutores'" :iconURL="'assets\images\student_icon.png'" :routex="'tutores.index'"/>
            <x-admin-btn :title="'Administración'" :iconURL="'assets\images\admin_icon.png'"/>
          </div>
          @if (Auth::user()->role->name === 'Super Admin')
            <div class="row mb-4">
              <x-admin-btn :title="'Super Admin'" :iconURL="'assets\images\secret_icon.png'" :routex="'sa.index'"/>
            </div>  
          @endif
        
      </div>
    </div>
</div>
@endsection
