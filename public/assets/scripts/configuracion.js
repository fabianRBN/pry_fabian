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