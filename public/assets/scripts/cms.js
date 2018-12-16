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


$('#route-form').on('submit', function(e){
    e.preventDefault()
    var data = objectifyForm($(this).serializeArray());
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')

    data.permisos = ($('[route-name="permisos"]').val() == null) ? 'all' : $('[route-name="permisos"]').val().join(',')

    console.log(data)

    if(type == 'edit'){
        Object.keys(data).forEach(function(e,i){
            var el = $('[route-name="'+ e +'"]');
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
        data.type = type;

        console.log(data)

        if(pass == false){
            toastr.error('Verifica que no haya campos vacios', 'Faltan datos')
        }else{
            $('[route-name="nombre"]').attr('disabled',true);
            $('[route-name="ruta"]').attr('disabled',true);
            $('[route-name="controlador"]').attr('disabled',true);
            $('[route-name="accion"]').attr('disabled',true);
            $('[route-name="permisos"]').attr('disabled',true);
            $('[route-name="grupo"]').attr('disabled',true);
            $('[route-name="activo"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post(url + 'mantenimiento/editar-ruta', data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Ruta guardada correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[route-name="nombre"]').attr('disabled',false);
                    $('[route-name="ruta"]').attr('disabled',false);
                    $('[route-name="controlador"]').attr('disabled',false);
                    $('[route-name="accion"]').attr('disabled',false);
                    $('[route-name="permisos"]').attr('disabled',false);
                    $('[route-name="grupo"]').attr('disabled',false);
                    $('[route-name="activo"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    }else{
        Object.keys(data).forEach(function(e,i){
            var el = $('[route-name="'+ e +'"]');
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
            $('[route-name="nombre"]').attr('disabled',true);
            $('[route-name="ruta"]').attr('disabled',true);
            $('[route-name="controlador"]').attr('disabled',true);
            $('[route-name="accion"]').attr('disabled',true);
            $('[route-name="permisos"]').attr('disabled',true);
            $('[route-name="grupo"]').attr('disabled',true);
            $('[route-name="activo"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post($(this).attr('action'), data, function(d){
                console.log(d)
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Ruta guardada correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[route-name="nombre"]').attr('disabled',false);
                    $('[route-name="ruta"]').attr('disabled',false);
                    $('[route-name="controlador"]').attr('disabled',false);
                    $('[route-name="accion"]').attr('disabled',false);
                    $('[route-name="permisos"]').attr('disabled',false);
                    $('[route-name="grupo"]').attr('disabled',false);
                    $('[route-name="activo"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})

$('a[data-edit-group]').on('click', function(){
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'mantenimiento/grupo?id=' + id, function(data){
        $('#group-form').attr('data-type','edit')
        var grupo = JSON.parse(data)
        $('#group-form').attr('data-id-form', grupo.id);
        $('[group-name="nombre"]').val(grupo.nombre).css('border-color', '#eaeaea');
        $('[group-name="orden"]').val(grupo.orden).css('border-color', '#eaeaea');
        $('[group-name="icono"]').val(grupo.icono).css('border-color', '#eaeaea');
        $('[group-name="activo"]').val(grupo.activo).css('border-color', '#eaeaea');
        $('[group-name="permisos"]').val(grupo.permisos.split(',')).css('border-color', '#eaeaea');
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })
    return false;
})



$('.routes').on('click', function(){
    console.log('click')
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');
    console.log(id)
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'mantenimiento/ruta?id=' + id, function(data){
        var ruta = JSON.parse(data)
        $('#route-form').attr('data-type','edit')
        $('#route-form').attr('data-id-form', ruta.id);
        $('[route-name="nombre"]').val(ruta.nombre).attr('disabled',false).css('border-color', '#eaeaea');
        $('[route-name="ruta"]').val(ruta.ruta).attr('disabled',false).css('border-color', '#eaeaea');
        $('[route-name="controlador"]').val(ruta.controlador).attr('disabled',false).css('border-color', '#eaeaea');
        $('[route-name="accion"]').val(ruta.accion).attr('disabled',false).css('border-color', '#eaeaea');
        $('[route-name="permisos"]').val(ruta.permisos.split(',')).attr('disabled',false).css('border-color', '#eaeaea');
        $('[route-name="grupo"]').val(ruta.grupo).attr('disabled',false).css('border-color', '#eaeaea');
        $('[route-name="activo"]').val(ruta.activo).attr('disabled',false).css('border-color', '#eaeaea');
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })
    return false;
})


$('#group-form').on('submit', function(e){
    e.preventDefault()
    var data = objectifyForm($(this).serializeArray());
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')

    console.log(type)

    data.permisos = ($('[group-name="permisos"]').val() == null) ? 'all' : $('[group-name="permisos"]').val().join(',')

    console.log(data)

    if(type == 'edit'){
        Object.keys(data).forEach(function(e,i){
            var el = $('[group-name="'+ e +'"]');
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
        data.type = type;

        console.log(data)

        if(pass == false){
            toastr.error('Verifica que no haya campos vacios', 'Faltan datos')
        }else{
            $('[group-name="nombre"]').attr('disabled',true);
            $('[group-name="orden"]').attr('disabled',true);
            $('[group-name="icono"]').attr('disabled',true);
            $('[group-name="activo"]').attr('disabled',true);
            $('[group-name="permisos"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post(url + 'mantenimiento/editar-grupo', data, function(d){
                console.log(d)
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Grupo guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[group-name="nombre"]').attr('disabled',false);
                    $('[group-name="orden"]').attr('disabled',false);
                    $('[group-name="icono"]').attr('disabled',false);
                    $('[group-name="activo"]').attr('disabled',false);
                    $('[group-name="permisos"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    }else{
        Object.keys(data).forEach(function(e,i){
            var el = $('[group-name="'+ e +'"]');
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
            $('[group-name="nombre"]').attr('disabled',true);
            $('[group-name="apellidos"]').attr('disabled',true);
            $('[group-name="usuario"]').attr('disabled',true);
            $('[group-name="correo"]').attr('disabled',true);
            $('[group-name="area"]').attr('disabled',true);
            $('[group-name="estatus"]').attr('disabled',true);
            $('[group-name="vigencia"]').attr('disabled',true);
            $('[group-name="password"]').attr('disabled', true);
            $('[group-name="password_conf"]').attr('disabled', true);
            $('[group-name="permiso"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post($(this).attr('action'), data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Grupo guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[group-name="nombre"]').attr('disabled',false);
                    $('[group-name="apellidos"]').attr('disabled',false);
                    $('[group-name="usuario"]').attr('disabled',false);
                    $('[group-name="correo"]').attr('disabled',false);
                    $('[group-name="area"]').attr('disabled',false);
                    $('[group-name="estatus"]').attr('disabled',false);
                    $('[group-name="vigencia"]').attr('disabled',false);
                    $('[group-name="password"]').attr('disabled', false);
                    $('[group-name="password_conf"]').attr('disabled', false);
                    $('[group-name="permiso"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})