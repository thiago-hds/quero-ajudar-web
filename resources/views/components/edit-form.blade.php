@props(['model', 'action', 'cancelUrl', 'enctype' => 'application/x-www-form-urlencoded'])

<form method="post" class="card position-relative" action="{{ $action }}" enctype="{{ $enctype }}">
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
    <div class="loading d-none">
        <div class="spinner-border text-light"
            role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</form>
