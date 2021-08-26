@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                    <div class="userPortrait-lg mx-auto py-5 mb-2">
                        <i class="fas fa-user fa-3x align-bottom"></i>
                    </div>
                    <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('studentList') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Estudiantes</h4>
                            <img class="ml-auto panel-btn-icon" src="assets\images\student_icon.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('materias') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Materias</h4>
                            <img class="ml-auto panel-btn-icon" src="assets\images\classes_icon.png" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Maestros</h4>
                            <img class="ml-auto panel-btn-icon" src="assets\images\teacher_icon.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Cordinadores</h4>
                            <img class="ml-auto panel-btn-icon" src="assets\images\staff_icon.png" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Tutores</h4>
                            <img class="ml-auto panel-btn-icon" src="assets\images\student_icon.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Administración</h4>
                            <img class="ml-auto panel-btn-icon" src="assets\images\admin_icon.png" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
