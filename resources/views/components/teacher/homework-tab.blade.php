<table class="table table-bordered">
    <thead>
        <tr>
            <th class="col-4 text-left"><h5>Nombre</h5></th>
            <th><h5>Fecha de entrega</h5></th>
            <th><h5>Asignado</h5></th>
            <th><h5>Actualizar</h5></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($homeworks as $h)
            @php $activasCounter++;@endphp
            <tr>
                <td class="text-left">
                    @if (!$monitor)
                        <a href="{{ route('maestroDash.tarea', $h->id) }}">{{ $h->title }}</a>     
                    @else
                        @if ($user->role->name === "Coordinador")
                            <a href="{{ route('monitor.tarea', $h->id) }}">{{ $h->title }}</a>
                        @else
                            <a href="{{ route('admin.teacherMonitorTareaIndv', $h->id) }}">{{ $h->title }}</a>
                        @endif
                    @endif
                </td>
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
                    @php
                        if (!$monitor) {
                            $tempRoute = "homework.destroy";
                        } else {
                            if ($user->role->name === "Coordinador") {
                                $tempRoute = "monitor.delHomework";
                            } else {
                                $tempRoute = "admin.teacherDelHomework";
                            }
                        }
                    @endphp
                    <x-delete-btn
                        :tooltip="'Borrar'"
                        :id="[$h->id]"
                        :text="'¿Deseas eliminar la tarea?'"
                        :elemName="'delHomework'"
                        :routeName="$tempRoute"
                    />
                </td>
            </tr>     
        @endforeach
        @if ($activasCounter === 0 && count($homeworks) != 0)
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