// jquery document ready function
$(function(){

    // Auto close alert flash
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(this).alert('close');
    });

});
