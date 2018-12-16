var app = angular.module('app', []);


app.controller('Products', function($scope,$http){

    $scope.product = {
        nombre: '',
        precio: '',
        descripcion:'',
        imagen: {},
        categoria: 1,
        tipo_pago: 0,
        opciones: [],
        tipo_Web: 0
	
    }
    $scope.edit = false;
    $scope.opcionesrm =[];

    $scope.deleteOption = function(index){
        if($scope.product.opciones[index].id){
            $scope.opcionesrm.push($scope.product.opciones[index]);
        }
        $scope.product.opciones.splice(index,1)
    }

    $('#tags').tagsInput();

    $('.productos').on('click', function(){
        console.log('Editando');
        var id = $(this).data('id');
        $scope.edit = true;
        toastr.info('Por favor espere','Cargando datos...');
        $http.get(SivozConfig.domain + 'catalogos/producto?id=' + id+'&imagen=1').then(function(data){
            $("html, body").animate({ scrollTop: 0 }, "slow");
            console.log(data.data)
            $scope.product = data.data;
            $scope.stepsModel = $scope.product.imagen;
            $scope.product.precio = Number($scope.product.precio).toFixed(2)
            $scope.product.tipo_pago = Number($scope.product.tipo_pago)
            $scope.product.categoria = Number($scope.product.categoria)
            $scope.product.venta = ($scope.product.venta == 1) ? true : false
            $scope.product.proximamente = ($scope.product.proximamente == 1) ? true : false
            $scope.product.demo = ($scope.product.demo == 1) ? true : false
            $scope.product.activo = ($scope.product.activo == 1) ? true : false
            $scope.product.venta_precio_real = ($scope.product.venta_precio_real == 1) ? true : false
            $scope.product.configurable = ($scope.product.configurable == 1) ? true : false
            $scope.product.orden =Number($scope.product.orden);
            $scope.product.opciones.forEach(function(e,i){
                e.precio = Number(e.precio)
                e.min = Number(e.min)
                e.max = Number(e.max)
                if(e.tipo == '1'){
                    e.valor = Number(e.valor);
                }
                e.exist = (e.exist =="true"); 
            })
            
            var tipoWeb = $scope.product.tipoWeb;
            

            if(  tipoWeb == "VDC" ){ $scope.product.tipo_Web =0}else
            if( tipoWeb == "Maquina Virtual"){ $scope.product.tipo_Web = 1} else
            if( tipoWeb == "Servidores Virtuales"){ $scope.product.tipo_Web = 1} else
            if( tipoWeb == "Otros"){ $scope.product.tipo_Web= 2}  

            $('#editor').trumbowyg('html', $scope.product.descripcion);
            $('.price').priceFormat({
                prefix: '$',
                clearOnEmpty: true
            });
            $('#price').priceFormat({
                prefix: '$',
                clearOnEmpty: true
            });
            $('#tags').tagsInput();
        })
       
    })
    $scope.stepsModel = {};

    $scope.imageUpload = function(event){
         var files = event.target.files; //FileList object
    
         for (var i = 0; i < files.length; i++) {
             var file = files[i];
                 var reader = new FileReader();
                 reader.onload = $scope.imageIsLoaded; 
                 reader.readAsDataURL(file);
         }
    }
    
    $scope.imageIsLoaded = function(e){
        $scope.$apply(function() {
            $scope.stepsModel=e.target.result;
        });
    }

    $scope.save = function(){
	
        $scope.product.venta = ($scope.product.venta == true) ? 1 : 0
        $scope.product.proximamente = ($scope.product.proximamente == true) ? 1 : 0
        $scope.product.demo = ($scope.product.demo == true) ? 1 : 0
        $scope.product.activo = ($scope.product.activo == true) ? 1 : 0
        $scope.product.venta_precio_real = ($scope.product.venta_precio_real == true) ? 1 : 0
        $scope.product.configurable = ($scope.product.configurable == true) ? 1 : 0
        $scope.product.imagen = $scope.stepsModel;
        $scope.product.opcionesrm = $scope.opcionesrm;
        $scope.product.orden = Number($scope.product.orden);
        var tipoWeb = Number($scope.product.tipo_Web);

        if(  tipoWeb == 0 ){ $scope.product.tipo_Web ="VDC"}else
        if( tipoWeb == 1){ $scope.product.tipo_Web = "Servidores Virtuales"} else
        if( tipoWeb == 2){  $scope.product.tipo_Web = "Otros"}

       
       
		if(angular.equals($scope.stepsModel, {})){
			$scope.product.imagenPath = '';
        }
		else{
			$scope.product.imagenPath = 'C:/log/' + $scope.product.nombre + '.jpg';
		}
		if($scope.product.nombre == '' || $scope.product.precio == '' || angular.equals($scope.stepsModel, {})){
            toastr.error('Verifica que no haya campos vacios', 'Faltan datos')
            $('[producto-name="nombre"]').css('border-color', '#26215e');
            $('[producto-name="precio"]').css('border-color', '#26215e');
            $('[producto-name="descripcion"]').css('border-color', '#26215e');
        }else{
            toastr.info('Guardando producto por favor espera..', 'Guardando')
            $('[producto-name="nombre"]').attr('disabled',true).css('border-color', '#eaeaea');
            $('[producto-name="precio"]').attr('disabled',true).css('border-color', '#eaeaea');
            $('[producto-name="descripcion"]').attr('disabled',true).css('border-color', '#eaeaea');
            $scope.product.descripcion = $('#editor').trumbowyg('html')
            console.log($scope.edit)
            console.log( $scope.product)
            if($scope.edit == true){
                $http.post(SivozConfig.domain + 'catalogos/edit-product', {product: $scope.product}).then(function(data){
                    console.log(data)
                    toastr.success('Se ha guardado el producto de manera correcta', 'Guardado!')
                    window.location.reload()
                })
            }else{
				console.log($scope.product)
                $http.post(SivozConfig.domain + 'catalogos/create-product', {product: $scope.product}).then(function(data){
                    console.log(data)
                    toastr.success('Se ha guardado el producto de manera correcta', 'Guardado!')
                    window.location.reload()
                })
            }
        }
        return false;
    }

    $scope.checkType = function(opcion){
        if(opcion.tipo == '2' || opcion.tipo == '5'){
            return true;
        }

        return false;
    }

    $scope.addOption = function(){
        $scope.product.opciones.push({
            tipo:'0',
            nombre: '',
            opciones: '',
            min: 0,
            max: 0,
            valor: '',
            precio: 0,
            opciones_precio: ''
        })
        $('.price').priceFormat({
            prefix: '$',
            clearOnEmpty: true
        });
    }

	
	$scope.addCar = function(){
        $scope.product.opciones.push({
            tipo:'0',
            nombre: '',
            opciones: '',
            min: 0,
            max: 0,
            valor: '',
            precio: 0,
            opciones_precio: ''
        })
        $('.price').priceFormat({
            prefix: '$',
            clearOnEmpty: true
        });
    }
	
    $('#editor').trumbowyg();
    $('#price').priceFormat({
        prefix: '$',
        clearOnEmpty: true
    });
    $('.price').priceFormat({
        prefix: '$',
        clearOnEmpty: true
    });

})