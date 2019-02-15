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



var prev = $('[data-json-prev]').data('json-prev');
var t = total;
if(prev == undefined || prev == null){
    
}else{
    if(prev.opciones== null || prev.opciones== undefined ){
       
    }else{

    for(var  i = 0; i < prev.opciones.length; i++){
        var el = $($('.form-group')[i]);
        var input = el.find('input');
        var type = input.attr('type')
        if(type == 'radio'){
            input.each(function(is,e){
                var value = $(e).val()
                $(e).prop('checked', false)
                if(value.trim() == prev.opciones[i].value.trim()){
                    console.log(value.trim(),prev.opciones[i].value.trim())
                    $(e).prop('checked', true)
                }
            })
        }else if(type == 'checkbox'){
            if(prev.opciones[i].value == 'on'){
                input.prop('checked', true)
            }else{
                input.prop('checked', false)
            }
        }else{
            input.val(prev.opciones[i].value)
        }
    }
    }
    setTimeout(function(){
        $('[data-change]').each(function(i,e){
            var p = $(this).data('precio');
            console.log(p)
            var tp = $(this).data('type');
            var v = $(this).val();
            var ids = '#' + $(this).data('change');
            var cops = $(this).data('cop');

            var valor_defecto = $(this).data('valor');
            if(tp == 1){
                if( Number(v)> Number(valor_defecto)){
                    t = t + (Number(p)*Number(v-valor_defecto))
                }
            }

            /*if(tp == 1){
                if(Number(v) > 1){
                    t = t + (Number(p)*Number(v))
                }
            }*/
            else{
                if($(this).is(":checked")){
                    t = t + Number(p);
                }
            }
        })
        $('[data-precio-global]').html('$'+t.formatMoney(2, '.', ',') + ' ' + tpago)
    }, 1000)
}
// Deshabilita la tecla enter en los data-change
$('[data-change]').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });

$('[data-change]').on('change', function(){

    var min = $(this).attr('min');
    var max =  $(this).attr('max');
    var val = $(this).val();
    var valor_defecto = $(this).data('valor');
    
    $(this).closest('.range-div').find('.range-slider__value').text(val);
    $(this).closest('.range-div').find('.custom-input').val(val);
    $(this).closest('.range-div').find("input[type=range]").val(val);
    
    if( Number( val) >Number(max)  || Number(val) < Number(min) ){
        //alert("El valor debe ser mayor a: "+ min +" y menor a: "+max);
        toastr.error("El valor debe ser mayor a: "+ min +" y menor a: "+max,'Alert');
        $(this).closest('.range-div').find('.range-slider__value').text(valor_defecto);

        $(this).val(valor_defecto);
    }else{
        
    }
    var val = $(this).val();
    var type = $(this).data('type');
    var id = '#' + $(this).data('change');
    var id2 = '#' + $(this).data('change')+'2';
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
        var min = $(this).attr('min');
        var valor_defecto = $(this).data('valor');
        if(tp == 1){
            if( Number(v) > Number(valor_defecto)){
                t = t + (Number(p)*(Number(v-valor_defecto)/2))
            }
        }else{
            if($(this).is(":checked")){
                t = t + Number(p);
            }
        }
    })
    
    $('[data-precio-global]').html('$'+t.formatMoney(2, '.', ',') + ' ' + tpago)
    $(id).html(val);
    $(id2).html(val)
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

$('#add-to-cart').on('click', function(e){
    e.preventDefault();

    var form = $('#options-form').serializeArray();
    var carrito = {
        id_cliente: $('[info]').data('cliente'),
        id_producto: $('[info]').data('producto'),
        total: t,
        subtotal: t,
        fecha_pago: calculatePaymentDate(tipoPago),
        estatus: 0,
        opciones: []
    }
    $('[data-change]').each(function(i,e){
        var name = $(this).data('change');
        var id = $(this).data('id')
        var tipo = $(this).attr('type');;
        
        if(tipo == 'radio'){
            var precio = $("input:radio[name='"+ name+"']:checked").data('precio');
        }else{
            var precio = $(this).data('precio');
        }


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
    carrito.token = $('#tokenCSRF').val();
    toastr.info('Por favor espere..','Añadiendo producto al carrito');
    waitingDialog.show();

    $.post(SivozConfig.domain + 'tienda/añadir-carrito', carrito).done(function(data){
        toastr.success('Estamos redireccionado, por favor espere..','Carrito actualizado correctamente')
        setTimeout(function(){
            window.location.href=SivozConfig.domain+'administracion/productos';
        },1500);
    }).error(function(){
        toastr.error('No pudimos guardar tu carrito, por favor intenta de nuevo','Whoops');
        waitingDialog.hide();

    })
})



$('#edit-to-cart').on('click', function(e){
    e.preventDefault();

    var form = $('#options-form').serializeArray();
    var carrito = {
        id_carrito: $('#idCarrito').val(),
        id_producto: $('#idproducto').val(),
        total: t,
        subtotal: t,
        fecha_pago: calculatePaymentDate(tipoPago),
        estatus:  $('#idestatus').val(),
        opciones: []
    }
    $('[data-change]').each(function(i,e){
        var name = $(this).data('change');
        var tipo = $(this).attr('type');;
        var id = $(this).data('id')
        
        if(tipo == 'radio'){
            var precio = $("input:radio[name='"+ name+"']:checked").data('precio');
        }else{
            var precio = $(this).data('precio');
        }

       
        form.forEach(function(ee,ii){

         

            if(ee.name == name){
                
                var found = false;
                
                carrito.opciones.forEach(function(eee,iii){
                    if(eee.opcion == id){
                        found = true;
                    }
                })
                
                if(!found){
                    
                    console.log(precio)
                    carrito.opciones.push({
                        opcion: id,
                        value: ee.value,
                        precio: precio
                    })

                    
                }
            }
        })
    })
    carrito.token = $('#tokenCSRF').val();
    toastr.info('Por favor espere..','Editando las caracteristicas de su producto ');
    // waitingDialog.show();
    console.log(carrito)
     $.post(SivozConfig.domain + 'tienda/edit-carrito', carrito).done(function(data){
         toastr.success('Estamos redireccionado, por favor espere..','Carrito actualizado correctamente')
         setTimeout(function(){
         window.location.href=SivozConfig.domain+'administracion/detalle?id='+$('#idCarrito').val();
         },1500);
     }).error(function(){
         toastr.error('No pudimos guardar tu carrito, por favor intenta de nuevo','Whoops');
         waitingDialog.hide();

     })
})