var id = $('[carrito]').data('id')
var total = $('[carrito-total]').data('total')

var json = $('[data-json]').data('json');
var estatus = json[0].codigo;
var fecha = null;
var precio = null;
var autorizacion = false;


$('.open-modal').on('click', function () {
    var json = $('[data-json]').data('json');
    estatus = $('#estatus').val();

    var asignaciones = $('#asignacion').val();
    var idestatusactual = $('#idestatus').val();
    asignaciones = JSON.parse(asignaciones);
    console.log({'asignacion ':asignaciones})
    asignaciones.forEach(element => {
        console.log(element)
        if(element.id_estatus == idestatusactual ){
            if(element.id_usuario != $('#idUsuario').val()){toastr.error('Este proceso no pertenece a tu usuario');}
        }
    });

 
    
    for (var i = 0; i < json.length; i++) {
        if (json[i].codigo == estatus) {

            $('#usuario_notificado').html('<option>Cargando..</option>')
            var permisos = '';

            var usuarios = json[i].usuarios;

            $.get($('#url').data('url') + '/api/usuarios', function (data) {
                var p = JSON.parse(data);



                usuarios.forEach(function (user) {
                    var str = user.permiso;
                    str = str.replace(" ", "&nbsp;");
                    permisos += '<optgroup label=' + str + '>';
                    p.forEach(function (e) {

                        if (e.permiso == user.id_permiso) {
                            permisos += '<option value="' + e.id + '">' + e.nombre + '</option>'
                        }
                    })
                    permisos += '</optgroup>';

                });



                $('#usuario_notificado').html(permisos)
            });


            if (json[i].email_smtp == 1) {
                $('#usericon').show();
            } else {
                $('#usericon').hide();
            }

            if (json[i].email_smtp_cliente == 1) {
                $('#clienticon').show();
            } else {
                $('#clienticon').hide();
            }


            $('#myModalLabel').html(json[i].titulo)
            $('[name="regresion"]').val(json[i].mensaje)

            if (json[i].id == 20) {
                $('[name="fecha_aprovisionamiento"]').fadeIn();
                $('[name="fecha_aprovisionamiento"]').attr('disabled', false);
                fecha = true;
            } else {
                $('[name="fecha_aprovisionamiento"]').fadeOut();
                $('[name="fecha_aprovisionamiento"]').attr('disabled', true);
                fecha = null;
            }
            if (json[i].id == 4) {
                $('[name="precio_aprovisionamiento"]').fadeIn();
                $('[name="precio_aprovisionamiento"]').val(total.toString().replace(",", ""));
                $('[name="precio_aprovisionamiento"]').attr('disabled', false);
                precio = total;
            } else {
                $('[name="precio_aprovisionamiento"]').fadeOut();
                $('[name="precio_aprovisionamiento"]').attr('disabled', true);

                document.getElementById("precio_aprovisionamiento_span").style.display = "none";
                document.getElementById("divprecio").style.display = "none";

                precio = null;
            }
        }
    }

})

$('#enviar-regresion').on('click', function () {
    var comentario = $('[name="regresion"]').val()
    var usuario_notificado = $('[name="usuario_notificado"]').val()
    toastr.info('Cambiando estatus.. Porfavor espere..');
    waitingDialog.show();
    $('#cancel-regresion').trigger('click')
    var data = {
        id: id,
        comentario: comentario,
        estatus: estatus,
        usuario_notificado: usuario_notificado
    }

    if (fecha !== null) {
        if ($('[name="fecha_aprovisionamiento"]').val() == '') {
            data.fecha_aprovisionamiento = moment().format('YYYY-MM-DD')
        } else {
            data.fecha_aprovisionamiento = $('[name="fecha_aprovisionamiento"]').val()
        }
    }
    if (precio !== null) {

        data.precio_aprovisionamiento = $('[name="precio_aprovisionamiento"]').val()
        if (isNumber(data.precio_aprovisionamiento)) {

        } else {
            toastr.error('Tuvimos un error al enviar la notificación por favor intenta de nuevo')
            waitingDialog.hide();
            return false;
        }

    }
    $.post(SivozConfig.domain + '/operacion/regresion', data).done(function (data) {

        data = JSON.parse(data);
        if (data.error == false) {
            toastr.success('Se ha enviado la alerta al cliente junto con tu comentario')
            window.location.reload()
            $('#cancel-regresion').trigger('click')
        } else {
            toastr.error('Tuvimos un error al enviar la notificación por favor intenta de nuevo')
        }
    })

})

$(document).ready(function () {
    $('#uploadImage').submit(function (event) {
       
       
        if ($('#uploadFile').val()) {
            event.preventDefault();
            
            $('#loader-icon').show();
            $('#targetLayer').hide();
            $(this).ajaxSubmit({
                
                target: '#targetLayer',
                beforeSubmit: function () {
                    $('.progress-bar').width('50%');
                },
                uploadProgress: function (event, position, total, percentageComplete) {
                    $('.progress-bar').animate({
                        width: percentageComplete + '%'
                    }, {
                        duration: 1000
                    });
                },
                success: function () {
                    $('#loader-icon').hide();
                    $('#targetLayer').show();

                    setTimeout(function(){
                        window.location.href=SivozConfig.domain+'operacion/carrito?id='+$('#id_carrito').val();
                        },1500);
                    
                   
                  
                },
                resetForm: true
            });
        }
        return false;
    });
});

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

function uploadsuccess(mensaje){
  
 
    if(!mensaje.error){
        toastr.success(mensaje.texto);
    }else{
        toastr.warning(mensaje.texto);
    }
}