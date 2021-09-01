@php
    // dd(count($materia->clases()->where('status', '1')->get()));
    $aClases = $materia->clases()->where('status', '1')->paginate(50);
@endphp
<table class="table table-bordered">
    @if (count($aClases) > 0)
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
      @forelse ($aClases as $c)
        <tr>
          <td class="text-left"><a href="{{ route('clase.edit', $c->id) }}">{{ ucwords($c->label) }}</a></td>
          {{-- Teacher --}}
          <td>
            @if ($c->teacher != 0)
              {{ ucwords($c->teacher()->name) }}
            @else
              Sin Maestro
            @endif
          </td>
          {{-- # Students --}}
          <td>
            {{ count($c->students) }}
          </td>
          <td>
            <span class="btn btn-sm btn-primary text-light mr-2 classBtnModal" data-toggle="tooltip" data-placement="top" title="Modificar" id="{{ $c->id }}"><i class="fas fa-pen" data-toggle="modal" data-target="#modClassModal"></i></span>
            @if ($c->status === 0)
              <a
                href="{{ route('clase.activate', $c->id) }}"
                class="btn btn-sm btn-success text-light mr-2"
                data-toggle="tooltip" data-placement="top" title="Activar">
                <i class="fas fa-check"></i>
              </a>
            @else
              <a
                href="javascript:void(0);"
                class="btn btn-sm btn-danger text-light mr-2"
                data-toggle="tooltip" data-placement="top" title="Desactivar"
                onclick="event.preventDefault(); document.getElementById('{{ 'claseDeactivate'.$c->id }}').submit();">
                <i class="fas fa-times"></i>
              </a>
              <form id="{{ 'claseDeactivate'.$c->id }}"
                action="{{ route('clase.deactivate', $c->id) }}"
                method="POST"
                style="display: none;"
                >@method('PUT') @csrf
              </form>
            @endif
            <a
              href="javascript:void(0);"
              data-toggle="tooltip" data-placement="top" title="Borrar"
              class="btn btn-sm btn-danger text-light"
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
                    document.getElementById('{{ 'delClase'.$c->id }}').submit();
                  }
                });"
            >
              <i class="far fa-trash-alt"></i>
            </a>
            <form id="{{ 'delClase'.$c->id }}"
              action="{{ route('clase.destroy', $c->id) }}"
              method="POST"
              style="display: none;"
            >@csrf
            @method('DELETE')
            </form>
          </td>
        </tr>
      @empty
        <div class="alert alert-danger" role="alert">
          Sin clases activas
        </div>
      @endforelse
    </tbody>
  </table>
  {{-- Paginator --}}
  {{$aClases->links()}}