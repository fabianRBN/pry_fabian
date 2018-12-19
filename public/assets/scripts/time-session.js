var n = $('#timevalue').val();
var start = $('#timevalue').val();
var l = document.getElementById("number");
if(start != 0){
    window.setInterval(function(){

        if( (tiempoSession - ( n - start)  ) == 30 ){
            
            toastr.info('En 30 segundos se desconectar el sistema por Inactividad');

        }

        if( ( n - start)> tiempoSession){
            location.href=SivozConfig.domain +"/logout";
        }
        n++;
       
      },1000);
}
