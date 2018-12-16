$(document).ready(function() {
    

    var $flowchart = $('#example');
    var $container = $flowchart.parent();

    var cx = $flowchart.width() / 2;
    var cy = $flowchart.height() / 2;

    // Panzoom initialization...
    $flowchart.panzoom();

    // Centering panzoom
    $flowchart.panzoom('pan', -cx + $container.width() / 2, -cy + $container.height() / 2);

    // Panzoom zoom handling...
    var possibleZooms = [0.5, 0.75, 1, 2, 3];
    var currentZoom = 1;
    $container.on('mousewheel.focal', function(e) {
        e.preventDefault();
        var delta = (e.delta || e.originalEvent.wheelDelta) || e.originalEvent.detail;
        var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
        currentZoom = Math.max(0, Math.min(possibleZooms.length - 1, (currentZoom + (zoomOut * 2 - 1))));
        $flowchart.flowchart('setPositionRatio', possibleZooms[currentZoom]);
        $flowchart.panzoom('zoom', possibleZooms[currentZoom], {
            animate: false,
            focal: e
        });
    });

    var data = $('[data-json]').data('json');
    var idData = $('[data-id]').data('id');
    var tipo = $('[data-tipo]').data('tipo');
    console.log(data)
    var estatus = [];

    for(let i = 0; i < data.original.length; i++){
        for(let j = 0; j < data.new.length; j++){
            if(data.original[i].id == data.new[j].id){

                let el = data.original[i];

                el.x = Number(data.new[j].x);
                el.y = Number(data.new[j].y);
                el.im = Number(data.new[j].im);
                el.om = Number(data.new[j].om);
                el.consecutivos = data.new[j].consecutivos;

                estatus.push(el)
            }
        }
    }
    
    var data = {
        operators: {},
        links: {}
    };
    var addX = 0;
    var addY = 0;

    var addOperator = function(d, id, operator, estatus){

        var consecutivos = estatus.consecutivos.split(',');
        for(let i = 0;i < consecutivos.length; i++){
            if(consecutivos[i] == 0){
            }else{
                operator.properties.outputs['output_' + consecutivos[i]] = {
                    label: 'Consecutivo',
                    multiple: (estatus.om == 1) ? true : false
                }
            }
        }
        data.operators[id] = operator

        data = d;
    }

    function generate_token(length){
        //edit the token allowed characters
        var a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split("");
        var b = [];  
        for (var i=0; i<length; i++) {
            var j = (Math.random() * (a.length-1)).toFixed(0);
            b[i] = a[j];
        }
        return b.join("");
    }
    
    
    var addLinks = function(id,estatus){

        var consecutivos = estatus.consecutivos.split(',');
        for(let i = 0;i < consecutivos.length; i++){
            if(consecutivos[i] == 0){
            }else{
                if(data.operators[consecutivos[i]] == undefined){}
                else{
                    data.operators[consecutivos[i]].properties.inputs['input_' + id] = {
                        label: 'Entrada',
                        multiple: (estatus.om == 1) ? true : false
                    }
                    data.links['link_' + generate_token(32)] = {
                        fromOperator: id,
                        fromConnector: 'output_' + consecutivos[i],
                        toOperator: consecutivos[i],
                        toConnector: 'input_' + id,
                        color: 'rgba(99, 79, 188, 0.1)'
                    }
                }
            }
        }
        
        
    }

    for(var i = 0; i < estatus.length; i++){
        addOperator(data, estatus[i].id, {
            top:  estatus[i].x,
            left: estatus[i].y,
            properties: {
                title: estatus[i].nombre,
                inputs: {},
                outputs: {}
            }
        }, estatus[i])
    }
    for(var i = 0; i < estatus.length; i++){
        addLinks(estatus[i].id, estatus[i])
    }


    // Apply the plugin on a standard, empty div...
    $flowchart.flowchart({
        data: data,
        linkWidth: 5,
        onLinkSelect: function(){
            console.log('selected')
            $('#delete-selected').fadeIn()
            return true;
        },
        onLinkUnselect: function(){
            console.log('unselected')
            $('#delete-selected').fadeOut()
            return true;
        },
        onOperatorSelect: function(){
            console.log('unselected')
            $('#delete-selected').fadeOut()
            return true;
        },
        defaultSelectedLinkColor:'rgba(99, 79, 188, 0.4)'
    });

    var $draggableOperators = $('.draggable_operator');

    function getOperatorData($element) {
        var nbInputs = parseInt($element.data('nb-inputs'));
        var nbOutputs = parseInt($element.data('nb-outputs'));
        var data = {
            properties: {
                title: $element.text(),
                inputs: {},
                outputs: {}
            }
        };

        var i = 0;
        for (i = 0; i < nbInputs; i++) {
            data.properties.inputs['input_' + i] = {
                label: 'Input ' + (i + 1)
            };
        }
        for (i = 0; i < nbOutputs; i++) {
            data.properties.outputs['output_' + i] = {
                label: 'Output ' + (i + 1)
            };
        }

        return data;
    }

    var operatorId = 0;

    $draggableOperators.draggable({
        cursor: "move",
        opacity: 0.7,

        helper: 'clone',
        appendTo: 'body',
        zIndex: 1000,

        helper: function(e) {
            var $this = $(this);
            var data = getOperatorData($this);
            return $flowchart.flowchart('getOperatorElement', data);
        },
        stop: function(e, ui) {
            var $this = $(this);
            var elOffset = ui.offset;
            var containerOffset = $container.offset();
            if (elOffset.left > containerOffset.left &&
                elOffset.top > containerOffset.top &&
                elOffset.left < containerOffset.left + $container.width() &&
                elOffset.top < containerOffset.top + $container.height()) {

                var flowchartOffset = $flowchart.offset();

                var relativeLeft = elOffset.left - flowchartOffset.left;
                var relativeTop = elOffset.top - flowchartOffset.top;

                var positionRatio = $flowchart.flowchart('getPositionRatio');
                relativeLeft /= positionRatio;
                relativeTop /= positionRatio;

                var data = getOperatorData($this);
                data.left = relativeLeft;
                data.top = relativeTop;

                $flowchart.flowchart('addOperator', data);
            }
        }
    });

    $('#save').on('click',function() {
        console.log('click')
        var data = $flowchart.flowchart('getData');
        var links = [];
        estatus.forEach(function(ee,ii){
            links.push({
                id: ee.id,
                position: {
                    x: data.operators[ee.id].top,
                    y: data.operators[ee.id].left,
                },
                consecutivos: []
            })
        })

        Object.keys(data.links).forEach(function(e,i){
            var link = data.links[e];

            links.forEach(function(ee,ii){
                if(ee.id == link.fromOperator){
                    ee.consecutivos.push(link.toOperator)
                }
            })
        })

        links.forEach(function(ee,ii){
            ee.consecutivos = ee.consecutivos.join(',')
        })

       

        toastr.info('Guardando flujo, porfavor espere....')

        let r = '';
        let i = 0;
        for(let l of links){
            for(let e of estatus){
                if(e.id == l.id){
                    if(i == links.length -1){
                        r += 'id;' + e.id + '__x;' + l.position.x + '__y;' + l.position.y + '__im;' + e.im + '__om;' + e.om + '__consecutivos;' + l.consecutivos;
                    }else{
                        r += 'id;' + e.id + '__x;' + l.position.x + '__y;' + l.position.y + '__im;' + e.im + '__om;' + e.om + '__consecutivos;' + l.consecutivos + '|';
                    }
                }
            }
            i = i+1;
        }

        $.post(SivozConfig.domain + 'catalogos/flujo-post', {id: idData, data: r, tipo: tipo}).done(function(data){
            toastr.success('Flujo guardado correctamente');

            window.location.reload()
            console.log(data)
        })
    });

    $('#delete-selected').on('click', function(){
        $flowchart.flowchart('deleteSelected');
        $('#delete-selected').fadeOut()
    })
});