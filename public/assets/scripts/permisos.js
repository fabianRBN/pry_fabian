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


$('#permiso-form').on('submit', function(e){
    e.preventDefault()
    var data = objectifyForm($(this).serializeArray());
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')

    console.log(data)

    if(type == 'edit'){
        Object.keys(data).forEach(function(e,i){
            var el = $('[permiso-name="'+ e +'"]');
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
            $('[permiso-name="nombre"]').attr('disabled',true);
            $('[permiso-name="area"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post(url + 'catalogos/edit-permiso', data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Ruta guardada correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[permiso-name="nombre"]').attr('disabled',false);
                    $('[permiso-name="area"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    }else{
        Object.keys(data).forEach(function(e,i){
            var el = $('[permiso-name="'+ e +'"]');
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
            $('[permiso-name="nombre"]').attr('disabled',true);
            $('[permiso-name="area"]').attr('disabled',true);
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
                    $('[permiso-name="nombre"]').attr('disabled',false);
                    $('[permiso-name="area"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})

$('.areas').on('click', function(){
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'catalogos/area?id=' + id, function(data){
        $('#area-form').attr('data-type','edit')
        var grupo = JSON.parse(data)
        $('#area-form').attr('data-id-form', grupo.id);
        $('[area-name="nombre"]').val(grupo.nombre).css('border-color', '#eaeaea');;
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })
    return false;
})



$('.permisos').on('click', function(){
    console.log('click')
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');
    console.log(id)
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'catalogos/permiso?id=' + id, function(data){
        $('#permiso-form').attr('data-type','edit')
        var grupo = JSON.parse(data)
        console.log(grupo)
        $('#permiso-form').attr('data-id-form', grupo.id);
        $('[permiso-name="nombre"]').val(grupo.nombre).css('border-color', '#eaeaea');;
        $('[permiso-name="area"]').val(grupo.area).css('border-color', '#eaeaea');;
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })
    return false;
})


$('#area-form').on('submit', function(e){
    e.preventDefault()
    var data = objectifyForm($(this).serializeArray());
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')

    console.log(data)

    if(type == 'edit'){
        Object.keys(data).forEach(function(e,i){
            var el = $('[area-name="'+ e +'"]');
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
            $('[area-name="nombre"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post(url + 'catalogos/edit-area', data, function(d){
                console.log(d)
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Grupo guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[area-name="nombre"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    }else{
        Object.keys(data).forEach(function(e,i){
            var el = $('[area-name="'+ e +'"]');
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
            $('[area-name="nombre"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post($(this).attr('action'), data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Grupo guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[area-name="nombre"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el usuario por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})