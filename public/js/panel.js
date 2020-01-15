$(document).ready(function() {
    $('.select2').select2()
    
    $('input[name=profile]').change(function(){
        console.log( $(this).val());
        if( $(this).val() == 'organization' )
        { 
            $('#organization_div').fadeIn('slow');
        }
        else
        { 
            $('#organization_div').fadeOut('slow');
            
        }
    });
});