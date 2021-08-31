@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Clase"=>'studentCourse',"Tarea"=>'tarea']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-secondary text-center">
                <div class="card-header">
                    <div class="my-3">
                        <h5>Instrucciones</h5>
                    </div>
                </div>

                <div class="card-body px-5">
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dapibus venenatis tortor, varius malesuada enim bibendum ut. Nunc quis neque quis metus vulputate pretium. Curabitur accumsan sollicitudin molestie. Quisque arcu lectus, rhoncus mollis lectus non, mattis malesuada est. Etiam id arcu euismod, ornare orci ut, elementum felis. Mauris commodo, libero pulvinar ornare ornare, arcu dolor congue augue, ac bibendum ligula diam et orci. Proin vel ligula mi. Morbi eget dapibus nunc. Pellentesque a orci posuere, rutrum nunc ut, mattis mauris. Proin quis suscipit diam. Maecenas ex orci, euismod vel sapien sed, vestibulum lobortis quam. Nullam gravida ut sem eu maximus. Ut sollicitudin, nisi et pellentesque varius, urna neque egestas massa, id posuere orci orci in dui. Proin sed elit quis massa dignissim posuere. Proin dolor lectus, commodo sit amet turpis eget, rhoncus iaculis magna. Donec semper facilisis volutpat. <br><br>Cras porttitor mauris vitae libero sagittis interdum. Curabitur laoreet, purus nec iaculis placerat, orci odio efficitur enim, at cursus leo felis vel dolor. Suspendisse nec finibus odio, nec fermentum nibh. Nunc venenatis feugiat diam, nec rhoncus lorem imperdiet sed. Duis aliquam nisi at volutpat interdum. Nulla facilisi. Integer erat nisi, scelerisque vel magna a, pellentesque suscipit velit. Quisque ut dui eros. Fusce.</p>
                </div>

                <div class="card-footer px-5">
                    <div class="row">
                        <div class="ml-auto mr-3">
                            <button class="btn btn-info text-white">Subir Tarea</button>
                        </div>
                        <div class="mr-3">
                            <button class="btn btn-danger text-white">Ver Video</button>
                        </div>
                        <div class="mr-3">
                            <button class="btn btn-dark text-white"><i class="fas fa-book"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="materiasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
