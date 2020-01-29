$(document).ready(function() {
    $('.select2').select2();
    $('.date-input').inputmask('99/99/9999');
    $('.phone-input').inputmask('(99) 999999999');
    $('.image-dropzone').dropzone();

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
        if($('.phone-input-group').length <= 4){
            $('.btn-add-phone').prop('disabled', false);
        }
    });
    
    $('.btn-add-phone').click(function(){
        addNewPhoneInput();
    });

    console.log('oi');
    console.log($('.phone-input-group').length);
    if($('.phone-input-group').length > 4){
        $('.btn-add-phone').prop('disabled', true);
    }
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
    var index = $('.phone-input-group').length;
    console.log(index);
    $('.phone-list').append(''+
            '<div class="input-group phone-input-group">'+
                '<input type="text" id="phone-'+ index +'" name="phones['+index+']" class="form-control" placeholder="(99) 999999999" />'+
                '<div class="input-group-prepend">'+
                    '<button class="btn btn-danger btn-remove-phone" type="button"><i class="fas fa-times"></i></button>'+
                '</div>'+
            '</div>'
    );
    $('#phone-' + index).inputmask('(99) 999999999');

    if(index >= 4){
        $('.btn-add-phone').prop('disabled', true);
    }
}