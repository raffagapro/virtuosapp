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
          <td class="text-left"><a href="{{ route('clase.index', $cc->id) }}">{{ ucwords($cc->label) }}</a></td>
          {{-- Teacher --}}
          <td>
            @if ($cc->teacher != 0)
              {{ ucwords($cc->teacher()->name) }}
            @else
              Sin Maestro
            @endif
          </td>
          {{-- # Studdens --}}
          <td>
            5
          </td>
          <td>
            <span class="btn btn-sm btn-primary text-light mr-2 classBtnModal" data-toggle="tooltip" data-placement="top" title="Modificar" id="{{ $cc->id }}"><i class="fas fa-pen" data-toggle="modal" data-target="#modClassModal"></i></span>
            @if ($cc->status === 0)
              <a
                href="javascript:void(0);"
                class="btn btn-sm btn-success text-light mr-2"
                data-toggle="tooltip" data-placement="top" title="Activar"
                onclick="event.preventDefault(); document.getElementById('{{ 'claseActivate'.$cc->id }}').submit();">
                <i class="fas fa-check"></i>
              </a>
              <form id="{{ 'claseActivate'.$cc->id }}"
                action="{{ route('clase.activate', $cc->id) }}"
                method="POST"
                style="display: none;"
                >@method('PUT') @csrf
              </form>
            @else
              <a
                href="javascript:void(0);"
                class="btn btn-sm btn-danger text-light mr-2"
                data-toggle="tooltip" data-placement="top" title="Desactivar"
                onclick="event.preventDefault(); document.getElementById('{{ 'claseDeactivate'.$cc->id }}').submit();">
                <i class="fas fa-times"></i>
              </a>
              <form id="{{ 'claseDeactivate'.$cc->id }}"
                action="{{ route('clase.deactivate', $cc->id) }}"
                method="POST"
                style="display: none;"
                >@method('PUT') @csrf
              </form>
            @endif
            <a
              href="javascript:void(0);"
              class="btn btn-sm btn-danger text-light"
              data-toggle="tooltip" data-placement="top" title="Borrar"
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
              action="{{ route('clase.destroy', $cc->id) }}"
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