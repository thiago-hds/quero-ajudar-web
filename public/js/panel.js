$(document).ready(function() {
    $('.select2').select2();
    $('.date-input').inputmask('99/99/9999');

    $('input[name=profile]').change(function(){
        if( $(this).val() == 'organization' ){ 
            $('#organization_div').show(400);
        }
        else{ 
            $('#organization_div').hide(400);
        }
    });
});

function deleteData(resource, id)
{
    //var url = '{{ route(":resource.destroy", ":id") }}';
    var url = '/:resource/:id';
    
    url = url.replace(':resource', resource);
    url = url.replace(':id', id);

    console.log(url);
    $("#form-delete").attr('action', url);
}