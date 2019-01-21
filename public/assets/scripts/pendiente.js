
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

                var doc = new jsPDF('p', 'pt','a4',true)
                

                cargarDatos(json);
                
                var table1 = 
                    tableToJson($('#table1').get(0)),
                    cellWidth = 180,
                    rowCount = 0,
                    cellContents,
                    leftMargin = 130,
                    topMargin = 300,
                    topMarginTable = 55,
                    headerRowHeight = 20,
                    rowHeight = 30,
            
                 l = {
                    orientation: 'l',
                    unit: 'mm',
                    format: 'a4',
                    compress: true,
                    fontSize: 12,
                    lineHeight: 1,
                    autoSize: false,
                    printHeaders: true
                };

                doc.setProperties({
                    title: 'Test PDF Document',
                    subject: 'This is the subject',
                    author: 'author',
                    keywords: 'generated, javascript, web 2.0, ajax',
                    creator: 'author'
                });

                doc.cellInitialize();

                    $.each(table1, function (i, row)
                    {

                        rowCount++;

                        $.each(row, function (j, cellContent) {

                            if (rowCount == 1) {
                                doc.margins = 1;
                                doc.setFont("times ");
                                doc.setFontType("italic");  // or for normal font type use ------ doc.setFontType("normal");
                                doc.setFontSize(12);                    


                                doc.cell(leftMargin, topMargin, cellWidth, rowHeight, cellContent, i); 
                            }
                            else if (rowCount == 2) {
                                doc.margins = 1;
                                doc.setFont("times ");
                                doc.setFontType("italic");  // or for normal font type use ------ doc.setFontType("normal");
                                doc.setFontSize(12);                    

                                doc.cell(leftMargin, topMargin, cellWidth, rowHeight, cellContent, i); 
                            }
                            else {

                                doc.margins = 1;
                                doc.setFont("times ");
                                doc.setFontType("italic");
                                doc.setFontSize(11);                    

                                doc.cell(leftMargin, topMargin, cellWidth, rowHeight, cellContent, i);  // 1st=left margin    2nd parameter=top margin,     3rd=row cell width      4th=Row height
                            }
                        })
                    })


                function getBase64Image(img) {
                    var canvas = document.createElement("canvas");
                    canvas.width = img.width + 85;
                    canvas.height = img.height + 30;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);
                    var dataURL = canvas.toDataURL("image/png");
                    return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
                  }
                  
                  var base64 = getBase64Image(document.getElementById("imageid"));

                    doc.addImage(base64, 'JPEG',10, 10, 60, 30);
                    doc.setFontSize(40)
                    
                    doc.setFontSize(20)
                    doc.text(155, 200, 'DESCRIPCIÓN DEL PRODUCTO')
                    doc.setFontSize(14)
                    doc.text(170, 250, 'Producto pendiente - '+json.producto)
                    doc.setFontSize(14)
                    doc.text(150, 280, json.id+' - '+ json.cliente+' / '+ json.nombre +' '+json.apellido)
                    doc.setFontSize(12)
                    var height = 310;
                    // json.opciones.forEach(element => {
                    //     doc.text(180,  height, element.value +' - '+  element.nombre )
                    //     height = height+30;
                    // });
                    doc.save(json.producto+'_'+json.cliente+'.pdf')
                    $("#table1").empty();
                    

            }else{
                toastr.error('No se pudo aprovisionar', 'Error')
            }
            
        }
        
    }



function tableToJson(table) {
    var data = [];
    
    // first row needs to be headers
    var headers = [];
    for (var i=0; i<table.rows[0].cells.length; i++) {
        headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
    }
    
    // go through cells
    for (var i=1; i<table.rows.length; i++) {
    
        var tableRow = table.rows[i];
        var rowData = {};
    
        for (var j=0; j<tableRow.cells.length; j++) {
    
            rowData[ headers[j] ] = tableRow.cells[j].innerHTML;
    
        }
    
        data.push(rowData);
    }       
    
    return data; 
}


function cargarDatos(DatosJson){
    
  console.log(DatosJson)
    $("#table1").append('<tr><td>Nombre</td>'+
    '<td>Valor</td>');
    for (i = 0; i < DatosJson.opciones.length; i++){

        console.log(DatosJson.opciones[i].nombre)

    $("#table1").append('<tr>' + 
        '<td align="center" style="dislay: none;">' + DatosJson.opciones[i].nombre + '</td>'+
        '<td align="center" style="dislay: none;">' + DatosJson.opciones[i].value + '</td>')
    }
}

    


