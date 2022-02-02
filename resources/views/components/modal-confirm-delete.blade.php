<x-adminlte-modal id="modal-delete" title="Exclusão de Registro" size="md" theme="danger"
    icon="fas fa-exclamation-triangle" v-centered static-backdrop>
    <p>Você tem certeza de que deseja excluir esse registro?</p>
    <x-slot name="footerSlot">
        <div class="w-100 d-flex justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <form id="form-delete" action="" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Confirmar Exclusão</button>
            </form>
        </div>
    </x-slot>
</x-adminlte-modal>
