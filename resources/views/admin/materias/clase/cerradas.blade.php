@php
    // dd(count($materia->clases()->where('status', '0')->get()));
    $cClases = $materia->clases()->where('status', '0')->paginate(2);
@endphp
<table class="table table-bordered">
    @if (count($cClases) > 0)
      <thead>
        <tr>
          <th class="col-4 text-left"><h5>Etiqueta</h4></th>
          <th class="col-4"><h5>Maestro</h4></th>
            <th class="col-2"><h5># Alumnos</h4></th>
          <th class="col-2"><h5>Actualizar</h4></th>
        </tr>
      </thead> 
    @endif
    <tbody>
        @forelse ($cClases as $cc)
        <tr>
          {{-- CHANGE ROTE TO CLASS EDIT PAGE!!!!  --}}
          <td class="text-left"><a href="{{ route('clase.index', $cc->id) }}">{{ $cc->label }}</a></td>
          {{-- Teacher --}}
          <td>
            @if ($cc->teacher != 0)
              {{ $cc->teacher()->name }}
            @else
              Sin Maestro
            @endif
          </td>
          {{-- # Studdens --}}
          <td>
            5
          </td>
          <td>
            <span class="btn btn-primary text-light mr-2 classBtnModal" id="{{ $cc->id }}"><i class="fas fa-pen" data-toggle="modal" data-target="#modClassModal"></i></span>
            <a
              href="javascript:void(0);"
              class="btn btn-danger text-light"
              onclick="
                event.preventDefault();
                swal.fire({
                  text: '¿Deseas eliminar la clase?',
                  showCancelButton: true,
                  cancelButtonText: `Cancelar`,
                  cancelButtonColor:'#62A4C0',
                  confirmButtonColor:'red',
                  confirmButtonText:'Eliminar',
                  icon:'error',
                }).then((result) => {
                  if (result.isConfirmed) {
                    document.getElementById('{{ 'delClase'.$cc->id }}').submit();
                  }
                });"
            >
              <i class="far fa-trash-alt"></i>
            </a>
            <form id="{{ 'delClase'.$cc->id }}"
              {{-- CHANGE ROUTE TO DELETE CLASSES!!!! --}}
              action="{{ route('materias.destroy', $cc->id) }}"
              method="POST"
              style="display: none;"
            >@csrf
            @method('DELETE')
            </form>
          </td>
        </tr>
      @empty
        <div class="alert alert-danger" role="alert">
          Sin clases cerradas
        </div>
      @endforelse
    </tbody>
  </table>
  {{-- Paginator --}}
  {{$cClases->links()}}