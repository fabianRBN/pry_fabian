var id = $('[carrito]').data('id')

$('#enviar-cancelar').on('click', function(){
    var comentario = $('[name="cancelar"]').val()
    waitingDialog.show();
    var token = $('#tokenCSRF').val();
    $.post(SivozConfig.domain + 'administracion/regresion', {id: id, comentario: comentario, token: token}).done(function(data){
        data = JSON.parse(data);
        if(data.error == false){
            toastr.success('Se ha enviado tu petición, pronto estarémos en contacto contigo')
            setTimeout(function(){
                window.location.href=SivozConfig.domain+'administracion/productos';
            },1000);
            $('#cancel-cancelar').trigger('click')
        }else{
            toastr.error('Tuvimos un error al enviar la notificación por favor intenta de nuevo')
        }
    })
})

