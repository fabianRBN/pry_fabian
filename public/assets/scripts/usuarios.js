function objectifyForm(formArray) {//serialize data function

    var returnArray = {};
    for (var i = 0; i < formArray.length; i++){
      returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function usernameIsValid(username) {
    return /^[0-9a-zA-Z_.-]+$/.test(username);
}

$('#area').on('change', function(){
    $('#permiso').html('<option>Cargando..</option>')
    var permisos = '<option>Permiso</option>';
    var el = $(this)
    $.get($('#url').data('url') + '/api/permisos', function(data){
        var p = JSON.parse(data);
        console.log(p)
        p.forEach(function(e,i){
            if(e.selectable == 1){
                if(e.area == el.val()){
                    permisos += '<option value="'+ e.id +'">'+ e.nombre +'</option>'
                }
            }
        })
        $('#permiso').html(permisos)
    });
    
})

$('#user-form').on('submit', function(){
    var data = objectifyForm($(this).serializeArray());
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')

    if(type == 'edit'){
        Object.keys(data).forEach(function(e,i){
            var el = $('[name="'+ e +'"]');
            if(el.attr('data-required') == true){
                if(data[e] == '' || data[e] == 'NA'){
                    el.css('border-color', '#26215e')
                    pass = false;
                }else{
                    el.css('border-color', '#eaeaea')
                }
    
                if(el.data('type') == 'password'){  
                    // Validate lowercase letters
                    var lowerCaseLetters = /[a-z]/g;
                    if(data[e].match(lowerCaseLetters)) { 
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener al menos una letra minúscula' , 'Error de formato')
                        pass = false;
                    }
    
                    // Validate capital letters
                    var upperCaseLetters = /[A-Z]/g;
                    if(data[e].match(upperCaseLetters)) { 
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener al menos una letra mayúscula' , 'Error de formato')
                        pass = false;
                    }
    
                    // Validate numbers
                    var numbers = /[0-9]/g;
                    if(data[e].match(numbers)) { 
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener al menos un número' , 'Error de formato')
                        pass = false;
                    }
    
                    // Validate length
                    if(data[e].length >= 8) {
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe tener más de 8 caracteres' , 'Error de formato')
                        pass = false;
                    }
                }
    
                if(el.data('same') !== undefined){
                    if(data[e] !== data[el.data('same')]){
                        toastr.error('El campo ' + el.attr('placeholder') + ' debe ser igual al campo ' + $('[name="' + el.data('same') +'"]').attr('placeholder'), 'Error de formato')
                        pass = false;
                    }
                }
    
                if(el.data('type') == 'email'){
                    if(validateEmail(data[e])){
                        el.css('border-color', '#eaeaea')
                    }else{
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' no es un correo electrónico válido' , 'Error de formato')
                        pass = false;
                    }
                }
    
                if(el.data('type') == 'username'){
                    if(usernameIsValid(data[e])){
                        el.css('border-color', '#eaeaea')
                    }else{
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener sólo los siguientes caracteres: Número , Letra , . , _ , - ' , 'Error de formato')
                        pass = false;
                    }
                }
            }
        })


        data.id = id;
        data.type = editor;
        console.log(data)

        data.notificacion = +$('#notificacion').is( ':checked' ) ;

        if(pass == false){
            toastr.error('Verifica que no haya campos vacios', 'Faltan datos')
        }else{
            $('[name="nombre"]').attr('disabled',true);
            $('[name="apellidos"]').attr('disabled',true);
            $('[name="usuario"]').attr('disabled',true);
            $('[name="correo"]').attr('disabled',true);
            $('[name="area"]').attr('disabled',true);
            $('[name="estatus"]').attr('disabled',true);
            $('[name="vigencia"]').attr('disabled',true);
            $('[name="password"]').attr('disabled', true);
            $('[name="password_conf"]').attr('disabled', true);
            $('[name="permiso"]').attr('disabled',true);
      
            $('#button-send').attr('disabled', true)
            $.post(url + 'mantenimiento/editar-usuario', data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Usuario guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[name="nombre"]').attr('disabled', false);
                    $('[name="apellidos"]').attr('disabled', false);
                    $('[name="usuario"]').attr('disabled', false);
                    $('[name="correo"]').attr('disabled', false);
                    $('[name="area"]').attr('disabled', false);
                    $('[name="estatus"]').attr('disabled', false);
                    $('[name="vigencia"]').attr('disabled', false);
                    $('[name="password"]').attr('disabled', false);
                    $('[name="password_conf"]').attr('disabled', false);
                    $('[name="permiso"]').attr('disabled', false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    }else{
        Object.keys(data).forEach(function(e,i){
            var el = $('[name="'+ e +'"]');
            if(el.data('required') == true){
                if(data[e] == '' || data[e] == 'NA'){
                    el.css('border-color', '#26215e')
                    pass = false;
                }else{
                    el.css('border-color', '#eaeaea')
                }
    
                if(el.data('type') == 'password'){  
                    // Validate lowercase letters
                    var lowerCaseLetters = /[a-z]/g;
                    if(data[e].match(lowerCaseLetters)) { 
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener al menos una letra minúscula' , 'Error de formato')
                        pass = false;
                    }
    
                    // Validate capital letters
                    var upperCaseLetters = /[A-Z]/g;
                    if(data[e].match(upperCaseLetters)) { 
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener al menos una letra mayúscula' , 'Error de formato')
                        pass = false;
                    }
    
                    // Validate numbers
                    var numbers = /[0-9]/g;
                    if(data[e].match(numbers)) { 
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener al menos un número' , 'Error de formato')
                        pass = false;
                    }
    
                    // Validate length
                    if(data[e].length >= 8) {
                        el.css('border-color', '#eaeaea')
                    } else {
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe tener más de 8 caracteres' , 'Error de formato')
                        pass = false;
                    }
                }
    
                if(el.data('same') !== undefined){
                    if(data[e] !== data[el.data('same')]){
                        toastr.error('El campo ' + el.attr('placeholder') + ' debe ser igual al campo ' + $('[name="' + el.data('same') +'"]').attr('placeholder'), 'Error de formato')
                        pass = false;
                    }
                }
    
                if(el.data('type') == 'email'){
                    if(validateEmail(data[e])){
                        el.css('border-color', '#eaeaea')
                    }else{
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' no es un correo electrónico válido' , 'Error de formato')
                        pass = false;
                    }
                }
    
                if(el.data('type') == 'username'){
                    if(usernameIsValid(data[e])){
                        el.css('border-color', '#eaeaea')
                    }else{
                        el.css('border-color', '#26215e')
                        toastr.warning('El campo ' + el.attr('placeholder') + ' debe contener sólo los siguientes caracteres: Número , Letra , . , _ , - ' , 'Error de formato')
                        pass = false;
                    }
                }
            }
        })
    
        if(pass == false){
            toastr.error('Verifica que no haya campos vacios', 'Faltan datos')
        }else{
            $('[name="nombre"]').attr('disabled',true);
            $('[name="apellidos"]').attr('disabled',true);
            $('[name="usuario"]').attr('disabled',true);
            $('[name="correo"]').attr('disabled',true);
            $('[name="area"]').attr('disabled',true);
            $('[name="estatus"]').attr('disabled',true);
            $('[name="vigencia"]').attr('disabled',true);
            $('[name="password"]').attr('disabled', true);
            $('[name="password_conf"]').attr('disabled', true);
            $('[name="permiso"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post($(this).attr('action'), data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Usuario guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[name="nombre"]').attr('disabled',false);
                    $('[name="apellidos"]').attr('disabled',false);
                    $('[name="usuario"]').attr('disabled',false);
                    $('[name="correo"]').attr('disabled',false);
                    $('[name="area"]').attr('disabled',false);
                    $('[name="estatus"]').attr('disabled',false);
                    $('[name="vigencia"]').attr('disabled',false);
                    $('[name="password"]').attr('disabled', false);
                    $('[name="password_conf"]').attr('disabled', false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})

$('[data-edit]').on('click', function(){
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');

    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'mantenimiento/usuario?id=' + id, function(data){
        var usuario = JSON.parse(data)
        $('#user-form').attr('data-type', 'edit');
        $('#user-form').attr('data-id-form', id);
        
        if(usuario.id == 2){
            $('[name="nombre"]').val(usuario.nombre).attr('disabled',true).css('border-color', '#eaeaea');
            $('[name="apellidos"]').val(usuario.apellidos).attr('disabled',true).css('border-color', '#eaeaea');
            $('[name="usuario"]').val(usuario.usuario).attr('disabled',true).css('border-color', '#eaeaea');
            $('[name="correo"]').val(usuario.correo).attr('disabled',true).css('border-color', '#eaeaea');
            $('[name="area"]').val(usuario.area).attr('disabled',true).css('border-color', '#eaeaea');
            $('[name="estatus"]').val(usuario.estatus).attr('disabled',true).css('border-color', '#eaeaea');
            $('[name="vigencia"]').val(usuario.vigencia).attr('disabled',true).css('border-color', '#eaeaea');
            $('#permiso').html('<option value="5">LLAVE MAESTRA</option>');
            $('[name="permiso"]').val(usuario.permiso).attr('disabled',true).css('border-color', '#eaeaea');
            if(usuario.notificacion == '1'){
                $('[name="notificacion"]').prop('checked',true );
            }else{
                $('[name="notificacion"]').prop('checked',false );
            }
            $('#user-form').attr('data-editor', 'password');
        }else{
            $('[name="nombre"]').val(usuario.nombre).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="apellidos"]').val(usuario.apellidos).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="usuario"]').val(usuario.usuario).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="correo"]').val(usuario.correo).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="area"]').val(usuario.area).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="estatus"]').val(usuario.estatus).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="vigencia"]').val(usuario.vigencia).attr('disabled',false).css('border-color', '#eaeaea');
            $('[name="password"]').attr('data-required', false).css('border-color', '#eaeaea');
            $('[name="password_conf"]').attr('data-required', false).css('border-color', '#eaeaea');
            $('[name="permiso"]').val(usuario.permiso).attr('disabled',false).css('border-color', '#eaeaea');
            $('#user-form').attr('data-editor', 'all');
            if(usuario.notificacion == '1'){
                $('[name="notificacion"]').prop('checked',true );
            }else{
                $('[name="notificacion"]').prop('checked',false );
            }
            var permisos = '<option>Permiso</option>';
            var el = $('#permisos')
            $.get($('#url').data('url') + '/api/permisos', function(data){
                var p = JSON.parse(data);
                p.forEach(function(e,i){
                    if(e.selectable == 1){
                        if(e.area == usuario.area){
                            if(e.id == usuario.permiso){
                                permisos += '<option selected value="'+ e.id +'">'+ e.nombre +'</option>'
                            }else{
                                permisos += '<option value="'+ e.id +'">'+ e.nombre +'</option>'
                            }
                        }
                    }
                })
                $('#permiso').html(permisos)
            });
        }
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })

    return false;
})


