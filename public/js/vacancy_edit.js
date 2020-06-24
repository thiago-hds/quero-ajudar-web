$('input[name=type]').change(function(){
    if( $(this).val() == 'recurrent' ){ 
        $('#frequency_div').show(400);
        $('#date_div').hide(400);
    }
    else{ 
        $('#frequency_div').hide(400);
        $('#date_div').show(400);
    }
});

$('input[name=frequency_negotiable]').change(function(){
    if( $(this).val() == 'no'){ 
        $('#periodicity_div').show(400);
    }
    else{ 
        $('#periodicity_div').hide(400);
    }
});

$('input[name=hours_negotiable]').change(function(){
    if( $(this).val() == 'no'){ 
        $('#hours_div').show(400);
    }
    else{ 
        $('#hours_div').hide(400);
    }
});


$('input[name=location_type]').change(function(){
    if($(this).val() == 'organization_address' || $(this).val() == 'specific_address'){ 
        $('#address_div').show(400);
    }
    else{ 
        $('#address_div').hide(400);
    }
});