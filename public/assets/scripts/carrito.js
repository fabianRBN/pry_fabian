var id = $('[carrito]').data('id')
var total = $('[carrito-total]').data('total')

var json = $('[data-json]').data('json');
var estatus = json[0].codigo;
var fecha = null;
var precio = null;

$('.open-modal').on('click', function(){
    var json = $('[data-json]').data('json');
    estatus  = $('#estatus').val();
    

    for(var i = 0; i < json.length; i++){
        if(json[i].codigo == estatus){
            console.log(json[i].email_smtp);
            if(json[i].email_smtp == 1){
                $('#usericon').show();
            }else{
                $('#usericon').hide();
            }
           
            if(json[i].email_smtp_cliente == 1){
                $('#clienticon').show();
            }else{
                $('#clienticon').hide();
            }
            

            $('#myModalLabel').html(json[i].titulo)
            $('[name="regresion"]').val(json[i].mensaje)

            if(json[i].id == 10){
                $('[name="fecha_aprovisionamiento"]').fadeIn();
                $('[name="fecha_aprovisionamiento"]').attr('disabled', false);
                fecha = true;
            }else{
                $('[name="fecha_aprovisionamiento"]').fadeOut();
                $('[name="fecha_aprovisionamiento"]').attr('disabled', true);
                fecha = null;
            }
            if(json[i].id == 4){
                $('[name="precio_aprovisionamiento"]').fadeIn();
                $('[name="precio_aprovisionamiento"]').val(total.toString().replace(",", ""));
                $('[name="precio_aprovisionamiento"]').attr('disabled', false);
                precio =  total;
            }else{
                $('[name="precio_aprovisionamiento"]').fadeOut();
                $('[name="precio_aprovisionamiento"]').attr('disabled', true);
                
                document.getElementById("precio_aprovisionamiento_span").style.display = "none";
                document.getElementById("divprecio").style.display = "none";

                precio = null;
            }
        }
    }

})

$('#enviar-regresion').on('click', function(){
    var comentario = $('[name="regresion"]').val()
    var usuario_notificado = $('[name="usuario_notificado"]').val()
    toastr.info('Cambiando estatus.. Porfavor espere..');
    waitingDialog.show();
    $('#cancel-regresion').trigger('click')
    var data =  {id: id, comentario: comentario, estatus: estatus, usuario_notificado: usuario_notificado}
    
    if(fecha !== null){
        if($('[name="fecha_aprovisionamiento"]').val() == ''){
            data.fecha_aprovisionamiento = moment().format('YYYY-MM-DD')
        }else{
            data.fecha_aprovisionamiento = $('[name="fecha_aprovisionamiento"]').val()
        }
    }
    if(precio !== null){
        
        data.precio_aprovisionamiento = $('[name="precio_aprovisionamiento"]').val()
        if(isNumber( data.precio_aprovisionamiento)){
      
        }else{
            toastr.error('Tuvimos un error al enviar la notificación por favor intenta de nuevo')
            waitingDialog.hide();
            return false;
        }
        
    }
    $.post(SivozConfig.domain + '/operacion/regresion', data).done(function(data){
        
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

function validateDecimal(valor) {
    var RE = /^\d*(\.\d{1})?\d{0,1}$/;
    if (RE.test(valor)) {
        return true;
    } else {
        return false;
    }
}
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }