var id = $('[suscripcion]').data('id')
var json = $('[data-json]').data('json');
var estatus = json[0].codigo;

$('.open-modal').on('click', function(){
    
    estatus  = $('#estatus').val();
    console.log(estatus)

    for(var i = 0; i < json.length; i++){
        if(json[i].codigo == estatus){
            $('#myModalLabel').html(json[i].titulo)
            $('[name="regresion"]').val(json[i].mensaje)
        }
    }
})

$('#enviar-regresion').on('click', function(){
    var comentario = $('[name="regresion"]').val()
    toastr.info('Cambiando estatus.. Porfavor espere..')
    $('#cancel-regresion').trigger('click')
   $.post(SivozConfig.domain + '/operacion/regresion-servicio', {id: id, comentario: comentario, estatus: estatus}).done(function(data){
        console.log(data)
        data = JSON.parse(data);
        if(data.error == false){
            toastr.success('Se ha enviado la alerta al cliente junto con tu comentario')
            window.location.reload()
            $('#cancel-regresion').trigger('click')
        }else{
            toastr.error('Tuvimos un error al enviar la notificación por favor intenta de nuevo')
        }
    })

})