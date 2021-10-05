<div class="card border-secondary text-center">
    <div class="card-header">
      <div class="my-3">
          <h5>Archivos</h5>
      </div>
    </div>
    <div class="card-body px-5">
        <table class="table">
            <tbody>
                @forelse ($homework->medias as $hm)
                    <tr>
                        <td class="align-middle">
                            <a href="{{ asset($hm->media) }}" target="_blank">{{ str_replace('https://virtuousapp.s3.us-east-2.amazonaws.com/tHomework/', '', $hm->media) }}</a>
                            @if ($user->role->name !== "Estudiante")
                                {{--  DELETE  --}}
                                {{-- $tempRoute is define in the component construct file --}}
                                <x-delete-btn
                                    :tooltip="'Borrar'"
                                    :id="[$hm->id]"
                                    :text="'¿Deseas eliminar el archivo?'"
                                    :elemName="'delFile'"
                                    :routeName="$tempRoute"
                                />   
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="align-middle">Sin archivos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>