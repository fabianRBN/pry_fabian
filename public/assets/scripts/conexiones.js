var timeSince = function(date) {
    if (typeof date !== 'object') {
      date = new Date(date);
    }
  
    var seconds = Math.floor((new Date() - date) / 1000);
    var intervalType;
  
    var interval = Math.floor(seconds / 31536000);
    if (interval >= 1) {
      intervalType = 'año';
    } else {
      interval = Math.floor(seconds / 2592000);
      if (interval >= 1) {
        intervalType = 'mes';
      } else {
        interval = Math.floor(seconds / 86400);
        if (interval >= 1) {
          intervalType = 'día';
        } else {
          interval = Math.floor(seconds / 3600);
          if (interval >= 1) {
            intervalType = "hora";
          } else {
            interval = Math.floor(seconds / 60);
            if (interval >= 1) {
              intervalType = "minuto";
            } else {
              interval = seconds;
              intervalType = "segundo";
            }
          }
        }
      }
    }
  
    if (interval > 1 || interval === 0) {
      intervalType += 's';
    }
  
    return interval + ' ' + intervalType;
  };


setInterval(function(){
    $('[timeago]').each(function(i,e){
        var time = $(e).attr('timeago');
        $(e).html(timeSince(new Date(time)))
    })
}, 2000 * 60)


$('[data-close-session]').on('click', function(){
  var d = $(this).data('close-session').split('|');

  var data = {
    cartera: d[0],
    usuario: d[1],
    fecha: d[2],
    tipo: d[3],
  }

  $.post(SivozConfig.domain + '/direccion/close-session', data).done(function(response){
    console.log(response)
    toastr.success('Se ha cerrado de manera exitosa esta sesión, al usuario que estaba conectado se le sacara del sistema','Cierre de Sesión')
    window.location.reload()
  })
})