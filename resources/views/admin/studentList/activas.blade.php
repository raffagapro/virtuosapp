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
            <x-delete-btn
              :tooltip="'Eliminar'"
              :id="[$c->id, $student->id]"
              :text="'¿Deseas eliminar la clase?'"
              :elemName="'rmClase'.$student->id"
              :routeName="'clase.rmStudent'"
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