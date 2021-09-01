@php
    // dd(count($materia->clases()->where('status', '0')->get()));
    $cClases = App\Models\Clase::where('teacher', $teacher->id)->where('status', '0')->paginate(50);
@endphp
<table class="table table-bordered">
    <tbody>
      @forelse ($cClases as $cc)
        <tr>
          <td class="text-left"><a href="{{ route('clase.edit', $cc->id) }}">{{ ucwords($cc->label) }}</a></td>
          {{-- # Students --}}
          <td>
            {{ count($cc->students) }}
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