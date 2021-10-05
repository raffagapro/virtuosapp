<div class="card border-secondary text-center">
    <div class="card-body px-0">
        <div class="my-3">
            <h3>{{ $clase->label }}</h3>
        </div>
        <div class="py-3">
            <table class="table">
                <thead>
                    <tr class="border-top">
                        <th class="col-6 text-left  border-right pl-5"><h5>Tareas</h4></th>
                        <th class="border-right"><h5>Fecha de entrega</h4></th>
                        <th class="pr-4"><h5>Status</h4></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clase->homeworks->sortBy('edate', SORT_REGULAR, true) as $h)
                        @if ($h->student === 0 || $h->student === $user->id )
                            @php $homeworkCounter++;@endphp
                            <tr>
                                <td class="text-left border-right pl-5">
                                    @if (!$monitor)
                                        <a href="{{ route('studentDash.tarea', $h->id) }}">{{ $h->title }}</a>
                                    @else
                                        <a href="{{ route('admin.studentMonitorTarea', [$h->id, $user->id]) }}">{{ $h->title }}</a>
                                    @endif
                                </td>
                                @php
                                    $edate = date('M d', strtotime($h->edate));
                                @endphp
                                <td class="border-right">{{ $edate }}</td>
                                @php
                                    $foundHomework = App\Models\StudentHomework::where('homework_id', $h->id)->where('user_id', $user->id)->first();
                                @endphp
                                @if ($foundHomework)
                                    @if ($foundHomework->status === 0 || $foundHomework->status === null)
                                        <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                    @elseif ($foundHomework->status === 1)
                                        <td class="pr-4"><span class="badge bg-warning tarea-status">Enviada</span></td>
                                    @elseif ($foundHomework->status === 2)
                                        <td class="pr-4"><span class="badge bg-info tarea-status">Complete</span></td>
                                    @endif
                                @else
                                    @if ($h->edate < $date)
                                        <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                    @else
                                        <td class="pr-4"><span class="badge bg-success tarea-status">Nueva</span></td>
                                    @endif
                                @endif                                            
                            </tr>   
                        @endif
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="alert alert-danger" role="alert">
                                    Sin tareas
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>