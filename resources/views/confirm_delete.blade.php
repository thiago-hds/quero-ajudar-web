<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Confirmação de Exclusão</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Você tem certeza que deseja excluir a {{$model_name}}?</p>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <form id="form-delete" action="" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Excluir</button>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->