<table class="table table-bordered">
    @php
        // dd(count($clase->homeworks));
    @endphp
    @if (count($clase->homeworks) > 0)
      <thead>
        <tr>
          <th class="col-4 text-left"><h5>Nombre</h5></th>
          <th><h5>Fecha de entrega</h5></th>
          <th><h5>Asignado</h5></th>
          <th><h5>Actualizar</h5></th>
        </tr>
      </thead> 
    @endif
    <tbody>
        @php $activasCounter = 0;@endphp
        @forelse ($clase->homeworks->sortBy('edate') as $h)
            @if ($h->edate >=$date)
                @php $activasCounter++;@endphp
                <tr>
                    <td class="text-left"><a href="{{ route('monitor.tarea', $h->id) }}">{{ $h->title }}</a></td>
                    @php
                        $edate = date('M d', strtotime($h->edate));
                    @endphp
                    <td>{{ $edate }}</td>
                    <td>
                    @if ($h->student === 0)
                        <span class="badge bg-info tarea-status">Grupal</span> 
                    @else
                        <span class="badge bg-warning tarea-status">{{ $h->getStudent()->name }}</span> 
                    @endif
                    </td>
                    <td>
                    <span class="btn btn-sm btn-primary text-white mr-2 homeworkBtn" id="{{ $h->id }}" data-toggle="modal" data-target="#modTareaModal"><i class="fas fa-pen" data-toggle="tooltip" data-placement="top" title="Modificar"></i></span>
                    <a
                        href="javascript:void(0);"
                        class="btn btn-sm btn-danger text-white mr-2"
                        data-toggle="tooltip" data-placement="top" title="Borrar"
                        onclick="
                            event.preventDefault();
                            swal.fire({
                            text: '¿Deseas eliminar la tarea?',
                            showCancelButton: true,
                            cancelButtonText: `Cancelar`,
                            cancelButtonColor:'#62A4C0',
                            confirmButtonColor:'red',
                            confirmButtonText:'Eliminar',
                            icon:'error',
                            }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('{{ 'delTarea'.$h->id }}').submit();
                            }
                            });"
                    >
                        <i class="far fa-trash-alt"></i>
                    </a>
                    <form id="{{ 'delTarea'.$h->id }}"
                    action="{{ route('monitor.delHomework', $h->id) }}"
                    method="POST"
                    style="display: none;"
                    >@csrf
                    @method('DELETE')
                    </form>
                    </td>
                </tr>     
            @endif
        @empty
            <div class="alert alert-danger" role="alert">
            Sin tareas
            </div>
        @endforelse
        @if ($activasCounter === 0 && count($clase->homeworks) != 0)
            <tr>
                <td colspan="4">
                <div class="alert alert-danger" role="alert">
                    Sin tareas
                </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>