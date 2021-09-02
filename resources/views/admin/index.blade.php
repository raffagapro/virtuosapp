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
        <div class="col-md-3">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                    <div class="mx-auto mb-3">
						<span class="fa-stack fa-5x">
							<i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
							<i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
						</span>
                    </div>
                    <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('estudiantes.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Estudiantes</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\student_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('materias.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Materias</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\classes_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('maestros.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Maestros</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\teacher_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start disabled">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Coordinadores</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\staff_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('tutores.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Tutores</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\student_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start disabled">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Administración</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\admin_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
