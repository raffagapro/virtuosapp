<div class="card border-secondary px-3">
    <div class="card-body">
        <table class="table text-center">
            <thead>
              <tr>
                <th class="col-9 text-left"><h5>Clases</h4></th>
                <th class="col-3"><h5>Status</h4></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($user->clases->where('status', 1) as $c)
                <tr>
                  <td class="text-left">
                      @if ($monitor)
                        <a href="{{ route('admin.studentMonitorClase', [$c->id, $user->id]) }}">{{ $c->label }}</a> 
                      @else
                        <a href="{{ route('studentDash.clase', $c->id) }}">{{ $c->label }}</a>
                      @endif
                  </td>
                  @php
                      $hws = $c->homeworks->all();
                      $pendingHomeworks = false;
                      $turnedHomeworks = false;
                      foreach ($hws as $thw) {
                        if ($thw->student === 0 || $thw->student === $user->id) {
                          if (!App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $user->id)->first()) {
                            $pendingHomeworks = true;
                          }else {
                            if (App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $user->id)->first()->status !== 2) {
                              if (App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $user->id)->first()->status === 1) {
                                $turnedHomeworks = true;
                              }elseif (App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $user->id)->first()->status === 0){
                                $pendingHomeworks = true;
                              }
                            }
                          }
                        }
                      }
                  @endphp
                  <td>
                    {{--  IF status pending is true  --}}
                    @if ($pendingHomeworks)
                      <span class="badge bg-danger tarea-status">Pendiente</span>
                    @elseif ($turnedHomeworks)
                      <span class="badge bg-warning tarea-status">Entregado</span>
                    @else
                      <span class="badge bg-info tarea-status">Complete</span>
                    @endif
                  </td>
                </tr>
              @empty
                <td class="text-left">Sin clases Activas</td>
              @endforelse
            </tbody>
        </table>
    </div>
</div>