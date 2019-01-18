
var json = null;

    $('#Modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
    
        var modal = $(this)
        
        if(button.data('titulo') == 1){
            var recipient = 'Aprovicionamiento automatico'
            $('#divvelocidad').show();
            $('#divorg').show();
            $('#divurl').show();

        }else{
            var recipient = 'Generacion de reporte'
            $('#divvelocidad').hide();
            $('#divorg').hide();
            $('#divurl').hide();
        }
         // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        json = button.data('json');
        modal.find('#ModalLabel').text(recipient);
        modal.find('#ventalabel').text(json.id);
        modal.find('#organizacionlabel').text(json.cliente);
        modal.find('#clientelabel').text(json.nombre +" "+ json.apellido);
        listaopciones(json.opciones);
        modal.find('#siglaslabel').text(json.id);
      
    })


    function listaopciones(opciones){
        var label = '<div class="form-group row" ><div class="col-sm-8"><label for="staticEmail" class=" col-form-label">'
        ,labelend = '</label>'
        labeldata = '</div><div class="col-sm-4"><label id="siglaslabel" for="staticEmail" class=" col-form-label" style="    font-weight: 10 !important;">'
        labeldataend ="</label></div></div>"
        ,m = '';
    
        // Right now, this loop only works with one
        // explicitly specified array (options[0] aka 'set0')
        for (i = 0; i < opciones.length; i += 1){
            m = m + label + opciones[i].nombre + labelend  + labeldata +opciones[i].value +labeldataend ;
        }
    
        document.getElementById('lista').innerHTML =  m ;
    }


    function aprovisionar(){


        if(json!= null){

            if(json.generacion == 1){
                json.siglas = $('#orginput').val();
                json.url = $('#urlinput').val();
                json.velocidad = $( "#sel1 option:selected" ).text();
                console.log(json);

                if(json.velocidad != '' && json.url != '' && json.siglas !=''){
                    $.post(SivozConfig.domain + 'operacion/doc-apro', json).done(function(data){
                        console.log(data)
                        if(!data.error){
                            toastr.success('El producto se aprovisionara automaticamente', 'Aprovisionando')
                            $('#Modal').modal('hide');
                            $('#orginput').val('');
                            $('#urlinput').val('');
                            json = null;
                        }else{
                            toastr.error('No se pudo aprovisionar', 'Error')
        
                        }
                        //window.location.reload()
                    }).fail(function() {
                        toastr.error('No se pudo aprovisionar', 'Error')
                    });
                }else{
                    toastr.error('No se pudo aprovisionar debes completar la informacion', 'Error')

                }
            }else if(json.generacion == 0 ){


                var doc = new jsPDF()

                doc.text(json.nombre, 10, 10)
                doc.save(json.producto+'_'+json.cliente+'.pdf')

            }else{
                toastr.error('No se pudo aprovisionar', 'Error')
            }
            
        }
        
    }


