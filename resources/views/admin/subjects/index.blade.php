@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-4">

            </div>
            <h3 class="col-4">Materias</h3>
            <div class="col-4">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="col-6 text-start"><h5>Nombre</h4></th>
                  <th><h5>Grado</h4></th>
                  <th><h5>Actualizar</h4></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                  <td><span class="btn btn-primary text-light mr-2"><i class="fas fa-pen"></i></span><span class="btn btn-danger text-light"><i class="far fa-trash-alt"></i></span></td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
                <tr>
                  <td class="text-start">Pendiente</td>
                  <td>Pendiente</td>
                </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
@endsection
