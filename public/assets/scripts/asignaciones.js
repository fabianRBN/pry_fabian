var asignaciones = [];
var cartera = '100';
$('#change').on('click', function(){
    cartera = $('#cartera').val();

    console.log(cartera)
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(SivozConfig.getRoute('mantenimiento/get-asignaciones?cartera=' + cartera), function(data){
        data = JSON.parse(data)

        var count =  data.usuarios.length;

        $('.dd-usuarios').html('')
        $('.dd-cartera').html('')

        data.usuarios.forEach(function(e,i){
            e.oid = e.id;
            e.id = e.nombre + ' ' + e.apellidos;

            if(e.cartera == false){
                $('.dd-usuarios').append(`
                <li class="dd-item dd-nochildren" data-id="${e.oid}">
                    <div class="dd-handle">${e.nombre + ' ' + e.apellidos}</div>
                </li>
                `)
            }else{
                $('.dd-cartera').append(`
                <li class="dd-item dd-nochildren" data-id="${e.oid}">
                    <div class="dd-handle">${e.nombre + ' ' + e.apellidos}</div>
                </li>
                `)
            }

            if(count == i+1){
                $('.dd').nestable({
                    callback: function(el,item, p){
                        var id = item.data('id')

                        data.usuarios.forEach(function(e,i){
                            if(e.oid == id){
                                if(e.cartera == false){
                                    e.cartera = {
                                        cartera: cartera,
                                        usuario: id
                                    }
                                    $('[data-id="'+ id +'"]').remove();
                                    $('.dd-cartera').append(`
                                    <li class="dd-item dd-nochildren" data-id="${e.oid}">
                                        <div class="dd-handle">${e.nombre + ' ' + e.apellidos}</div>
                                    </li>
                                    `)
                                }else{
                                    e.cartera = false;
                                    $('[data-id="'+ id +'"]').remove();
                                    $('.dd-usuarios').append(`
                                    <li class="dd-item dd-nochildren" data-id="${e.oid}">
                                        <div class="dd-handle">${e.nombre + ' ' + e.apellidos}</div>
                                    </li>
                                    `)
                                }
                            }
                        })

                        asignaciones = data.usuarios;
                    }
                });
            }
        })

        $('#cartera-nombre').html(data.cartera.nombre)

        

        $('.hide-on-load').fadeOut()
        $('#save').attr('disabled',false)
    })    
})

$('#save').on('click', function(){
    $.post(SivozConfig.getRoute('mantenimiento/edit-asignaciones'), {data: asignaciones, cartera: cartera}, function(data){
        toastr.success('Asignaciones guardadas correctamente' , 'Enhorabuena!')
    
        setTimeout(function(){
            window.location.reload()
        }, 2000)
    })
})