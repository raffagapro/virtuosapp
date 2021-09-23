@php
    // dd(count($materia->clases()->where('status', '1')->get()));
    $aClases = $student->clases()->where('status', '1')->paginate(50);
@endphp
<table class="table table-bordered">
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
          {{--  ACTUALIZAR  --}}
          <td>
            <a
              href="javascript:void(0);"
              data-toggle="tooltip" data-placement="top" title="Eliminar"
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
                    document.getElementById('{{ 'rmClase'.$c->id }}').submit();
                  }
                });"
            >
              <i class="far fa-trash-alt"></i>
            </a>
            <form id="{{ 'rmClase'.$c->id }}"
              action="{{ route('clase.rmStudent', [$c->id, $student->id]) }}"
              method="POST"
              style="display: none;"
            >@csrf
            @method('GET')
            </form>
          </td>
        </tr>
      @empty
        <div class="alert alert-danger" role="alert">
          Sin clases activas
        </div>
      @endforelse
      {{-- <tr>
        <td class="text-left"><a href="">Matemáticas 101</a></td>
        <td class="text-secondary">Docente: Estefanía</td>
        <td>
          <span class="btn btn-sm btn-danger text-white mr-2 classBtnModal"><i class="far fa-trash-alt"></i></span>
        </td>
      </tr> --}}
    </tbody>
</table>
{{-- Paginator --}}
{{$aClases->links()}}