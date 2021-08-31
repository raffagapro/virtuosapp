@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Materias"=>'materias']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-2">
              <img class="studentPortrait" src="" alt="">
            </div>
            <div class="col-10 text-left pl-0">
              <h4>Jorge Eduardo Solis López</h4>
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-5">
                      <p>Edad: 12 años</p>
                      <p>Grado: 6to A</p>
                    </div>
                    <div class="col-7 pl-0">
                      <p>CURP: xxxxxxxxxxx</p>
                      <p>Modalidad: Homeschooling</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-6 text-left pl-0">
                      <p>Tutor 1 : Jorge solis</p>
                      <p>Tutor 2 : Jacqueline Lopez</p>
                    </div>
                    <div class="col-6 text-right pl-0">
                      <button class="btn btn-primary"><i class="fas fa-pen fa-fw"></i></button>
                      <button class="btn btn-danger"><i class="fas fa-trash-alt fa-fw"></i></button>
                      <button class="btn btn-info"><i class="fas fa-plus fa-fw"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#activas"><h4>Clases Activas</h4>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#cerradas"><h4>Clases Cerradas</h4></a>
                </li>
              </ul>
            </div>
          </div>
          <table class="table table-bordered">
            <tbody>
              <tr>
                {{-- CHANGE ROTE TO CLASS EDIT PAGE!!!!  --}}
                <td class="text-left"><a href="">Matemáticas 101</a></td>
                <td class="text-secondary">Docente: Estefanía</td>
                <td>
                  <span class="btn btn-sm btn-primary text-white mr-2 classBtnModal"><i class="fas fa-pen"></i></span>
                  <span class="btn btn-sm btn-danger text-white mr-2 classBtnModal"><i class="far fa-trash-alt"></i></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection