$( "#button-send" ).click(function() {
   
   
    var data = {'id_estatus': $( "#selectareas option:selected" ).val() , 'id_permiso': $( "#selectpermisos option:selected" ).val()};

    $.post(SivozConfig.domain + "operacion/areasnotificadas",data).done( function( data ) {

    var result = JSON.parse(data);
       if(result.error){
            toastr.error(result.mensaje,'Error!');
       }else{
           toastr.success(result.mensaje,'Enhorabuena!');
           setTimeout(function(){
            window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
            },500);
       }

       console.log(result.mensaje)

      });
 
});

$( "#button-send-commend" ).click(function() {
   
   
    var data = {'id_estatus': $( "#selectareascom option:selected" ).val() , 'value': $( "#textarea" ).val()};

    $.post(SivozConfig.domain + "operacion/mensajes",data).done( function( data ) {

    var result = JSON.parse(data);
       if(result.error){
            toastr.error(result.mensaje,'Error!');
       }else{
           toastr.success(result.mensaje,'Enhorabuena!');
           setTimeout(function(){
            window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
            },500);
       }

       console.log(result.mensaje)

      });
 
});


$( "#button-send-aprovisionado" ).click(function() {
   
   
    var data = {'id_estatus': $( "#selectaprovicionado option:selected" ).val() };

    $.post(SivozConfig.domain + "operacion/estadoaprov",data).done( function( data ) {

    var result = JSON.parse(data);
       if(result.error){
            toastr.error(result.mensaje,'Error!');
       }else{
           toastr.success(result.mensaje,'Enhorabuena!');
           setTimeout(function(){
            window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
            },500);
       }

       console.log(result.mensaje)

      });
 
});

$( "#button-send-extension" ).click(function() {
   
   
     var data = {'extension': $( "#extension" ).val() , 'tipo': 'create' };
 
     $.post(SivozConfig.domain + "operacion/extensiones",data).done( function( data ) {
 
     var result = JSON.parse(data);
        if(result.error){
             toastr.error(result.mensaje,'Error!');
        }else{
            toastr.success(result.mensaje,'Enhorabuena!');
            setTimeout(function(){
             window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
             },500);
        }
 
        console.log(result.mensaje)
 
       });
  
 });


function deleteextension(id){
     var data = {'extension': id , 'tipo': 'delete' };
 
     $.post(SivozConfig.domain + "operacion/extensiones",data).done( function( data ) {
 
     var result = JSON.parse(data);
        if(result.error){
             toastr.error(result.mensaje,'Error!');
        }else{
            toastr.success(result.mensaje,'Enhorabuena!');
            setTimeout(function(){
             window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
             },500);
        }
 
        console.log(result.mensaje)
 
       });
  
}


function deleteAreaNotificada(id){
    

    $.post(SivozConfig.domain + "operacion/deleteAN",{'id':id} ).done( function( data ) {

        var result = JSON.parse(data);
           if(result.error){
                toastr.error(result.mensaje,'Error!');
           }else{
               toastr.success(result.mensaje,'Enhorabuena!');
               setTimeout(function(){
                window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
                },500);
           }
    
           console.log(result.mensaje)
    
    });
     
}


function deletemensaje(id){
    

    $.post(SivozConfig.domain + "operacion/deletemensaje",{'id':id} ).done( function( data ) {

        var result = JSON.parse(data);
           if(result.error){
                toastr.error(result.mensaje,'Error!');
           }else{
               toastr.success(result.mensaje,'Enhorabuena!');
               setTimeout(function(){
                window.location.href=SivozConfig.domain+'mantenimiento/configuracion';
                },500);
           }
    
           console.log(result.mensaje)
    
    });
     
}