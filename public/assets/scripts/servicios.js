$('#editor').trumbowyg();
$('#price').priceFormat({
    prefix: '$',
    clearOnEmpty: true
});

$('#servicio-form').on('submit', function(){
    var data = objectifyForm($(this).serializeArray());
    var pass = true;
    var type =  $(this).attr('data-type');
    var editor =  $(this).attr('data-editor');
    var id =  $(this).attr('data-id-form');
    var url = $('#url').data('url')

    console.log(data)

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

        if(pass == false){
            toastr.error('Verifica que no haya campos vacios', 'Faltan datos')
        }else{
            $('[name="nombre"]').attr('disabled',true);
            $('[name="precio"]').attr('disabled',true);
            $('[name="forma_pago"]').attr('disabled',true);
            $('[name="descripcion"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post(url + 'catalogos/editar-Servicio', data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Servicio guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[name="nombre"]').attr('disabled',false);
                    $('[name="precio"]').attr('disabled',false);
                    $('[name="forma_pago"]').attr('disabled',false);
                    $('[name="descripcion"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el Servicio por favor intenta de nuevo más tarde' , 'Error de carga')
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
            $('[name="precio"]').attr('disabled',true);
            $('[name="forma_pago"]').attr('disabled',true);
            $('[name="descripcion"]').attr('disabled',true);
            $('#button-send').attr('disabled', true)
            $.post($(this).attr('action'), data, function(d){
                var d = JSON.parse(d);
    
                if(d.error == false){
                    toastr.success('Servicio guardado correctamente' , 'Enhorabuena!')
    
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }else{
                    $('[name="nombre"]').attr('disabled',false);
                    $('[name="precio"]').attr('disabled',false);
                    $('[name="forma_pago"]').attr('disabled',false);
                    $('[name="descripcion"]').attr('disabled',false);
                    $('#button-send').attr('disabled', false)
                    toastr.warning('No pudimos guardar el Servicio por favor intenta de nuevo más tarde' , 'Error de carga')
                }
            })
        }
    
    }

    return false;
})

$('.servicios').on('click', function(){
    var el = $(this);
    var url = $('#url').data('url')
    var id = el.data('id');
    toastr.info('Porfavor espere...', 'Cargando datos')
    $.get(url + 'catalogos/servicio?id=' + id, function(data){
        $('#servicio-form').attr('data-type','edit')
        console.log(data)
        var grupo = JSON.parse(data)
        $('#servicio-form').attr('data-id-form', grupo.id);
        $('[servicio-name="nombre"]').val(grupo.nombre).css('border-color', '#eaeaea');;
        $('[servicio-name="precio"]').val(grupo.precio).css('border-color', '#eaeaea');;
        $('[servicio-name="forma_pago"]').val(grupo.forma_pago).css('border-color', '#eaeaea');;
        $('[servicio-name="descripcion"]').val(grupo.descripcion).css('border-color', '#eaeaea');;
        $('#editor').trumbowyg('html', grupo.descripcion);
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })
    return false;
})
