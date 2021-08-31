@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Clase"=>'maestroCourse',"test"=>'maestroClase.index']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <h3>test</h3>
          <div class="row mb-3">
            <div class="col">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#activas"><h4>Activas</h4>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#cerradas"><h4>Cerradas</h4></a>
                </li>
              </ul>
            </div>
            <div class="col-3 ml-auto">
              <button class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">Abrir test<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <div class="tab-content">
            {{-- TAB ABIERTAS --}}
            <div class="tab-pane active" id="activas">
              
            </div>
            {{-- TAB CERRADAS --}}
            <div class="tab-pane" id="cerradas">
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Abrir test</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Materia -->
<div class="modal fade" id="modClassModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Modificar <span id="claseNameCont"></span></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        

      </div>
    </div>
  </div>
</div>

@endsection
