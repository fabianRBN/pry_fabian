var total = $('[data-precio-global]').data('precio-global');
var tipoPago = $('[data-precio-global]').data('tipo-pago');
var tpago = '/mes';
switch (tipoPago) {
    case 0:
        tpago = '/dia'
        break;
    case 1:
        tpago = '/semana'
        break;
    case 2:
        tpago = '/quincena'
        break;
    case 3:
        tpago = '/mes'
        break;
    case 4:
        tpago = '/año'
        break;
}


var t = total;
$('[data-change]').on('change', function(){
    var val = $(this).val();
    var type = $(this).data('type');
    var id = '#' + $(this).data('change');
    var precio = $(this).data('precio');
    var cop = $(this).data('cop')
    t = total;

    if(type == 4){
        if($(this).is(":checked")){
            val = 'Si'
        }else{
            val = 'No'
        }
    }

    $('[data-change]').each(function(i,e){
        var p = $(this).data('precio');
        var tp = $(this).data('type');
        var v = $(this).val();
        var ids = '#' + $(this).data('change');
        var cops = $(this).data('cop')
        if(tp == 1){
            if(Number(v) > 1){
                t = t + (Number(p)*Number(v))
            }
        }else{
            if($(this).is(":checked")){
                t = t + Number(p);
            }
        }
    })
    
    $('[data-precio-global]').html('$'+t.formatMoney(2, '.', ',') + ' ' + tpago)
    $(id).html(val)
})

var calculatePaymentDate =  function(p){
    var r = moment();
    switch (p) {
        case 0:
            r = moment()
            break;
        case 1:
            r = moment().add(1, 'week')
            break;
        case 2:
            var rr = moment().date();
            if(rr < 15){
                r = moment().add(15 - rr, 'days')
            }else if(rr > 15 && rr < moment().daysInMonth()){
                r = moment().add(moment().daysInMonth() - rr, 'days')
            }
            break;
        case 3:
            r = moment().add(1, 'month')
            break;
        case 4:
            r = moment().add(1,'year')
            break;
    }
    return r.format('YYYY-MM-DD');
}

function btnPassProducto(idProducto) {
     
    var form = $('#options-form').serializeArray();
    var carrito = {
        //id_producto: $('[info]').data('producto'),
        id_producto: idProducto,
        total: t,
        subtotal: t,
        fecha_pago: calculatePaymentDate(tipoPago),
        estatus: 0,
        opciones: []
    }
    console.log(carrito)
    $('[data-change]').each(function(i,e){
        var name = $(this).data('change');
        var id = $(this).data('id')
        var precio = $(this).data('precio');

        form.forEach(function(ee,ii){
            if(ee.name == name){
                var found = false;
                carrito.opciones.forEach(function(eee,iii){
                    if(eee.opcion == id){
                        found = true;
                    }
                })

                if(!found){
                    carrito.opciones.push({
                        opcion: id,
                        value: ee.value,
                        precio: precio
                    })
                }
            }
        })
    })
    toastr.info('Por favor espere..','Añadiendo producto al carrito');
    $.post(SivozConfig.domain + 'add-to-cart', carrito).done(function(data){
        toastr.success('Estamos redireccionado, por favor espere..','Carrito actualizado correctamente')
        setTimeout(function(){
            window.location.href=SivozConfig.domain+'carrito';
        })

        console.log(data)
    }).error(function(){
        toastr.error('No pudimos guardar tu carrito, por favor intenta de nuevo','Whoops')
    })
}

$('#add-to-cart').on('click', function(e){
    e.preventDefault();

    var form = $('#options-form').serializeArray();
    var carrito = {
        id_producto: $('[info]').data('producto'),
        total: t,
        subtotal: t,
        fecha_pago: calculatePaymentDate(tipoPago),
        estatus: 0,
        opciones: []
    }
    console.log(carrito)
    $('[data-change]').each(function(i,e){
        var name = $(this).data('change');
        var id = $(this).data('id')
        var precio = $(this).data('precio');

        form.forEach(function(ee,ii){
            if(ee.name == name){
                var found = false;
                carrito.opciones.forEach(function(eee,iii){
                    if(eee.opcion == id){
                        found = true;
                    }
                })

                if(!found){
                    carrito.opciones.push({
                        opcion: id,
                        value: ee.value,
                        precio: precio
                    })
                }
            }
        })
    })
    toastr.info('Por favor espere..','Añadiendo producto al carrito');
    $.post(SivozConfig.domain + 'add-to-cart', carrito).done(function(data){
        toastr.success('Estamos redireccionado, por favor espere..','Carrito actualizado correctamente')
        setTimeout(function(){
            window.location.href=SivozConfig.domain+'carrito';
        })

        console.log(data)
    }).error(function(){
        toastr.error('No pudimos guardar tu carrito, por favor intenta de nuevo','Whoops')
    })
})