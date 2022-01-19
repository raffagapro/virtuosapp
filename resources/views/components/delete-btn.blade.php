<a
    href="javascript:void(0);"
    class="btn btn-sm btn-danger text-white mr-2"
    {{--  data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"  --}}
    data-toggle="tooltip" data-placement="top" title="{{ $routeName }}"
    onclick="
        event.preventDefault();
        swal.fire({
        text: '{{ $text }}',
        showCancelButton: true,
        cancelButtonText: `Cancelar`,
        cancelButtonColor:'#62A4C0',
        confirmButtonColor:'red',
        confirmButtonText:'Eliminar',
        icon:'error',
        })
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('{{ $elemID }}').submit();
            }
        });"
>
    <i class="far fa-trash-alt"></i>
</a>
<form id="{{ $elemID }}"
    action="{{ route($routeName, $id) }}"
    method="POST"
    style="display: none;"
>
    @csrf
    @if ($formMethod === "GET")
        @method('GET')
    @else
        @method('DELETE')
    @endif
</form>