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