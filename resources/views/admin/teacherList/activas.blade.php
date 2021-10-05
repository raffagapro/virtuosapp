@php
    // dd(count($materia->clases()->where('status', '1')->get()));
    $aClases = App\Models\Clase::where('teacher', $teacher->id)->where('status', '1')->orderBy('label')->paginate(50);
@endphp
<table class="table table-bordered">
    <tbody>
      @forelse ($aClases as $c)
        <tr>
          <td class="text-left"><a href="{{ route('clase.edit', $c->id) }}">{{ ucwords($c->label) }}</a></td>
          {{-- # Students --}}
          <td>
            {{ count($c->students) }}
          </td>
          {{--  ACTUALIZAR  --}}
          <td>
            <x-delete-btn
              :tooltip="'Eliminar'"
              :id="[$c->id, $teacher->id]"
              :text="'¿Deseas eliminar la clase?'"
              :elemName="'rmClase'"
              :routeName="'maestros.rmTeacher'"
            />
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