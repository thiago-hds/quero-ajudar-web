@props(['model', 'action', 'cancelUrl'])
<form method="post" class="card" action="{{ $action }}">
    <div class="card-body">
        @if (isset($model))
            @method('PATCH')
        @endif
        @csrf

        {{ $slot }}
    </div>

    <div class="card-footer">
        <x-adminlte-button class="float-right" type="submit" label="Enviar"
            theme="success" icon="fas fa-save" />

        <a class="btn btn-danger" href="{{ $cancelUrl }}">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>
