<div class="card border-secondary text-center">
    <div class="card-header">
      <div class="my-3">
          <h5>Alumnos</h5>
      </div>
    </div>
    <div class="card-body px-5">
        <table class="table">
            <tbody>
                @forelse ($students as $s)
                    <tr>
                        <td class="align-middle">{{ $s->name }}</td>
                        <td class="align-middle text-right py-0">
                            @php
                                $foundHomework = App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $s->id)->first();
                            @endphp
                            @if ($foundHomework)
                                @if ($foundHomework->status === 0 || $foundHomework->status === null)
                                    <span class="badge btn-danger text-white">Pendiente</span>
                                @elseif ($foundHomework->status === 1)
                                    <span class="badge badge-info">{{ '('. $foundHomework->dateParser() . ') Enviado' }}</span>
                                @elseif ($foundHomework->status === 2)
                                    <span class="badge badge-info">{{ '('. $foundHomework->dateParser() . ') Completado' }}</span>
                                @endif
                            @else
                                <span class="badge btn-danger text-white">Pendiente</span>
                            @endif
                            {{--  RETROALIMENTACION  --}}
                            <button id="{{ $s->id }}" class="btn retroBtn @if (!$homework->hasRetro($s->id)) btn-warning @else btn-primary @endif" data-toggle="modal" data-target="#retroMod">
                                <i class="fas @if (!$homework->hasRetro($s->id)) fa-chalkboard-teacher @else fa-check-double @endif" data-toggle="tooltip" data-placement="top" title="Retroalimentacion"></i>
                            </button>
                            {{-- STUDENT HOMEWORK --}}
                            @if (isset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $s->id)->first()->media))
                                <a href="{{ asset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $s->id)->first()->media) }}" class="btn btn-primary text-white" target="_blank">
                                    <i class="fas fa-book" data-toggle="tooltip" data-placement="top" title="Tarea Alumno"></i>
                                </a>  
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="align-middle">Sin clases registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Retro -->
<div class="modal fade" id="retroMod" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentNameCont"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="retroForm" action="{{ route('retro.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="homeworkId" id="homeworkId" value="{{ $homework->id }}">
                    <input type="hidden" name="studentId" id="studentId">
                    <input type="hidden" name="retroId" id="retroId">
                    {{--  BODY  --}}
                    <div class="form-group">
                        <textarea class="form-control" id="body" name="body" placeholder="Retroalimentacion" rows="8"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>