$(document).ready(function() {
    $('.select2').select2();
    $('.date-input').inputmask('99/99/9999');
    $('.phone-input').inputmask('(99) 999999999');

    // controle de exibição select de instituições no cadastro de usuários
    $('input[name=profile]').change(function(){
        if( $(this).val() == 'organization' ){ 
            $('#organization_div').show(400);
        }
        else{ 
            $('#organization_div').hide(400);
        }
    });

    // controle de multiplos telefones
	$(document.body).on('click', '.btn-remove-phone' ,function(){
        $(this).closest('.phone-input-group').remove();
    });

    $('.btn-add-phone').click(function(){
        addNewPhoneInput();
    });
});

// inclui a rota correta de remoção no modal de confirmação
//ao clicar no botão deletar de algum item da tabela
function deleteData(resource, id)
{
    var url = '/:resource/:id';
    
    url = url.replace(':resource', resource);
    url = url.replace(':id', id);

    $("#form-delete").attr('action', url);
}

// adiciona um novo input de telefone no form
function addNewPhoneInput(){
    var index = $('.phone-input-group').length + 1;
    $('.phone-list').append(''+
            '<div class="input-group phone-input-group">'+
                '<input type="text" id="phone-'+ index +'" name="phone['+index+']" class="form-control" placeholder="(99) 999999999" />'+
                '<div class="input-group-prepend">'+
                    '<button class="btn btn-danger btn-remove-phone" type="button"><i class="fas fa-times"></i></button>'+
                '</div>'+
            '</div>'
    );
    $('#phone-' + index).inputmask('(99) 999999999');
}