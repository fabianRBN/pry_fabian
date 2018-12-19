var SivozConfig = {
    domain: 'https://smart.cntcloud2.com/',
    client: 'Innovasys',
    getRoute: function(route){
        return this.domain + route
    }
}
var tiempoSession = 3600; // El tiempo esta dado en segundos
moment.locale('es')
Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

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

function showpass() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

$(".glyphicon-eye-open").click(function() {

    $(this).toggleClass("glyphicon-eye-close");

    var input = $(this).closest('.input-group').find('input');
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

$('#notificaciones-list').on('click', function(e){
    e.preventDefault();

    var count = $('[data-notificaciones]').data('notificaciones');

    if(count > 0){
        $.post(SivozConfig.domain + '/operacion/read-notifications').done(function(data){
            $('#notify-badge').html('0')
            $('[data-notificaciones]').data('notificaciones',0)
        })
    }
})

var productos = function(id){
 
    var token = $('#tokenCSRF').val();
    window.location.href=SivozConfig.domain+'tienda/producto?id='+id+'&token='+token;

}

var checkLogin = function(){

    $.get(SivozConfig.domain + '/mantenimiento/auth').done(function(data){
        data = JSON.parse(data)
        if(data.posicion == undefined){
            toastr.warning('Supervisión ha cerrado tu sesión');
            setTimeout(function(){
                window.location.href=SivozConfig.domain + '/logout';
            }, 3000)
        }else{
            setTimeout(function(){
                checkLogin()
            }, 10000 * 60)
        }
    })
}
setTimeout(function(){
    checkLogin()
}, 10000 * 60)


$( document ).ready(function() { 
 

    $("#btndelete").click(function(event) {
        $("#notpro").remove();
    });


    var elementos = [];
    var elementosTexto =[];
    var array_texto =[];
    $('.col-md-4').each( function(index){ 
       // elementosTexto.push($(this).find('.panel-body').text());
        

        var  s = $(this).find('.panel-body').find('.expandable')[0];
        var añadido= false;
        $(s).find('p').each(function(index){
         
            if(index == 0){
                añadido = false;
            }
            if($(this).text().localeCompare('') == 1 && añadido == false ){
                array_texto.push(($(this).text()));
                añadido = true;
            }
            
        })
    });
    $('.col-md-4').each( function(index){ 

        $(this).find('div.expandable').empty();
        $(this).find('div.expandable').append($('<p style="text-align : justify;">'+ array_texto[index]+'</p>'));
     


    
    });



    $('.col-md-4').each( function(index){ 
        $(this).find('div.expandable p').expander({
            slicePoint: 100, // si eliminamos por defecto es 100 caracteres
            expandText: '[...]', // por defecto es 'read more...'
            collapseTimer: 5000, // tiempo de para cerrar la expanción si desea poner 0 para no cerrar
            userCollapseText: '[^]' // por defecto es 'read less...'
        });

        elementos.push($(this).height());
        elementos.sort(function(a, b) {
            return a - b;
          });

        elementosTexto.push($(this).find('.panel').height());
        elementosTexto.sort(function(a, b) {
              return a - b;
        });
    });

    
    var height = parseInt(elementos[0] +40 +  (elementos[elementos.length -1 ] - elementos[0] )/2);
    
    
    $('.col-md-4').each( function(index){ 
        $(this).css('min-height',elementos[elementos.length -1]);
        $(this).find('.panel').css('margin-bottom','0px ');
        
       // $(this).find('.panel').css('min-height',elementos[elementos.length -1]);
        
      /*  $(this).find('.panel-body').height(height - $(this).find('.panel-heading').height() -$(this).find('.panel-footer').height()  -100  );
        $(this).find('.panel-body').css('overflow','hidden');
        
        
        */
 
    });

    var height_body = 0;
    
    $('.col-md-4').find('#opciones').each( function(index){
        
        if($(this).height() > height_body){
            height_body = $(this).height();
        }
        $(this).height(height_body) 
    });



});


var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		/**
		 * Opens our dialog
		 * @param message Custom message
		 * @param options Custom options:
		 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
		 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
		 */
		show: function (message, options) {
			// Assigning defaults
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Procesando';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null // This callback runs after the dialog was hidden
			}, options);

			// Configuring dialog
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h3').text(message);
			// Adding callbacks
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
			// Opening dialog
			$dialog.modal();
		},
		/**
		 * Closes dialog
		 */
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);


