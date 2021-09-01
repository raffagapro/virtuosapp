@php
    // dd(count($materia->clases()->where('status', '0')->get()));
    $cClases = $student->clases()->where('status', '0')->paginate(50);
@endphp
<table class="table table-bordered">
    <tbody>
      @forelse ($cClases as $cc)
        <tr>
          <td class="text-left"><a href="{{ route('clase.edit', $cc->id) }}">{{ ucwords($cc->label) }}</a></td>
          {{-- Teacher --}}
          <td>
            @if ($cc->teacher != 0)
              {{ ucwords($cc->teacher()->name) }}
            @else
              Sin Maestro
            @endif
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