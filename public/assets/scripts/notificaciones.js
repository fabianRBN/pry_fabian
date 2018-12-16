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


$('#notificacion-form').on('submit', function(e){
    e.preventDefault()
    var data = objectifyForm($(this).serializeArray());
    data.id_usuario = $('#id_usuario').val().join(',')
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')
    data.email_smtp =  +$('#email_smtp').is( ':checked' );


    console.log(data)

    if(type == 'edit'){
        Object.keys(data).forEach(function(e,i){
            var el = $('[notificacion-name="'+ e +'"]');
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
            $('[notificacion-name]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post(url + 'catalogos/edit-notificacion', data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Notificación guardada correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[notificacion-name="nombre"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar la notificacion por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    }else{
        Object.keys(data).forEach(function(e,i){
            var el = $('[notificacion-name="'+ e +'"]');
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
            $('[notificacion-name="nombre"]').attr('disabled',true);
            $('[notificacion-name="notificacion"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post($(this).attr('action'), data, function(d){
                console.log(d)
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Notificación guardada correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[notificacion-name]').attr('disabled',false);
                    $('[notificacion-name="notificacion"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar la notificación por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})

$('.notificaciones').on('click', function(){
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'catalogos/notificacion?id=' + id, function(data){
        console.log(data)
        $('#notificacion-form').attr('data-type','edit')
        var grupo = JSON.parse(data)
        $('#notificacion-form').attr('data-id-form', grupo.id);
        $('[notificacion-name="titulo"]').val(grupo.titulo).css('border-color', '#eaeaea');;
        $('[notificacion-name="comentario"]').val(grupo.comentario).css('border-color', '#eaeaea');;
        $('[notificacion-name="id_permiso"]').val(grupo.id_permiso).css('border-color', '#eaeaea');;
        $('[notificacion-name="id_estatus"]').val(grupo.id_estatus).css('border-color', '#eaeaea');;
        $('[notificacion-name="id_usuario"]').val(grupo.id_usuario.split(',')).css('border-color', '#eaeaea');;
        $("html, body").animate({ scrollTop: 0 }, "slow");

        if(JSON.parse(data).email_smtp == '1'){
            $('[notificacion-name="email_smtp"]').prop('checked',true );
        }else{
            $('[notificacion-name="email_smtp"]').prop('checked',false );
        }
    })
    return false;
})

