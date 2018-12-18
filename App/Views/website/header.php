<?php
header('Access-Control-Allow-Origin: *'); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title><?php echo App\Config::Title ?> | <?php echo $title ?></title>

	<?php 
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'X-XSS-Protection: 1;mode=block' );
		
		
	?>

    <!-- main css file -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/fonts/stylesheet.css') ?>">
    <link rel="stylesheet" href="<?php \Core\Router::assets('website/css/custom/style.css') ?>">
	<!-- responsive css file -->
    <link rel="stylesheet" href="<?php \Core\Router::assets('website/css/responsive/responsive.css') ?>">
    <!-- favicon -->
	<link rel="icon" type="image/png" href="<?php \Core\Router::assets('assets/img/favicon.png')?> ">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/toastr/toastr.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/cnt.css') ?>">
	<style>
		.slides {display:none}
		.cnt-left, .cnt-right, .cnt-badge {cursor:pointer}
		.cnt-badge {height:13px;width:13px;padding:0}
	</style>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body class="home">

	<div class="preloader">
		<div class="sk-cube-grid">
		  <div class="sk-cube sk-cube1"></div>
		  <div class="sk-cube sk-cube2"></div>
		  <div class="sk-cube sk-cube3"></div>
		  <div class="sk-cube sk-cube4"></div>
		  <div class="sk-cube sk-cube5"></div>
		  <div class="sk-cube sk-cube6"></div>
		  <div class="sk-cube sk-cube7"></div>
		  <div class="sk-cube sk-cube8"></div>
		  <div class="sk-cube sk-cube9"></div>
		</div>
	</div>

    <!-- ======= 1.01 Header Area ====== -->
    <header>
    	<div class="headerTopArea">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-5 col-sm-2 col-xs-5">
    					<div class="langOpt">
    						<span class="langIcon"><span class="langCode"></span></span>
    					</div>
    				</div>
    				<div class="col-md-7 col-sm-10 col-xs-7">
    					<ul class="topInfo">
    						<li class="call"><a href="tel:+214-5212-829"><i class="icofont icofont-ui-call"></i>1800-268267</a></li>
    						<li class="email"><a href="mailto:support@spark.com"><i class="icofont icofont-ui-v-card"></i>soporte@cnt.gob.ec</a></li>
							<?php if(\Core\Session::has('sivoz_auth')): ?>
                            	<li class="call">
									<?php $ruta= 'administracion'; if( $_SESSION['sivoz_auth']->permiso == '10' ){$ruta= 'catalogos/productos';	}else{$ruta= 'administracion';} ?>
									<a href="<?php \Core\Router::url($ruta) ?>">
								<i class="icofont icofont-user-alt-3">
						
								</i>Administrador</a>
								</li>


                            <?php else: ?>
                            <li class="clientAreaLi"><span><i class="icofont icofont-user-alt-3"></i>Conectate</span></li>
                            <?php endif ?>
    					</ul>
    					<div class="clientLogin">
    						<form action="<?php \Core\Router::url('login') ?>" method="post">
    							<div class="closeBtn"><i class="icofont icofont-close"></i></div>
    							<div class="h5">Conectate</div>
    							<div class="userName"><input name="email" type="email" placeholder="Correo electrónico" type="text"></div>
    							<div class="password"><input name="password" autocomplete="off" placeholder="Contraseña" id="password" type="password"></div>
								<input type="checkbox" onclick="showpass()" style="    margin: 15px;"><label> Mostrar Contraseña </label>


    							
								<?php  if(isset($_SESSION['intentos'])): ?>
									<?php   
										
										if(isset($_SESSION['intentosfecha'])){

										
											$fecha= $_SESSION['intentosfecha'];
											$hoy = getdate();
											if($fecha['hours']< $hoy['hours'] || $fecha['minutes']< $hoy['minutes'] ||  ($hoy['minutes'] -$fecha['minutes'] )> 30 ){
												$_SESSION['intentos']= 1;
												$_SESSION['intentosfecha']=getdate();
											}
										}
									?>
									<?php if($_SESSION['intentos'] > 2): ?>
									<button type="button" class="btn btn-primary btn-lg btn-block"  onclick='location.reload(true);'>Espera un momento </button>
									<br>
									<div class="h5" style="    color: #f7d16e; align-items: center; align-content: center; text-align: center;">Intentos de login alcanzados</div>
								<?php else:?>
								<input type="submit" style="    width: 100%;" value="Conectate">
									<?php endif?>
								<?php else:?>
								<input type="submit" style="    width: 100%;" value="Conectate">

								<?php endif?>

								<input  type="hidden" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >

    							<div class="h5">Olvidaste tu contraseña? <a style=" color: #f7d16e;" href="<?php \Core\Router::url('forgot') ?>">Click aquí</a></div>
    							<div class="logBtm">
    								<div class="h5">Aún no tienes una cuenta?</div>
    								<a href="<?php \Core\Router::url('register') ?>" class="signUp">Registrate aquí.</a>
    							</div>
    						</form>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="headerBottomArea">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-2 col-sm-3 col-xs-9">
    					<a href="<?php \Core\Router::url('') ?>" class="logo"><img src="<?php \Core\Router::assets('assets/img/logo-dark.png') ?>" style="width: 80% !important; height: 140% !important;" alt=""></a>
    				</div>
    				<div class="col-md-9 menuCol col-sm-9 col-xs-9">
						<center>
								
							</center>
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only"></span>
								<i class="fa fa-navicon"></i>
							</button>
						</div>
    					<nav id="navbar" class="collapse navbar-collapse">
    						<ul id="nav">
								<li><a href="<?php \Core\Router::url('?tipo=2') ?>">Servidores Virtuales</a></li>
								<li><a href="<?php \Core\Router::url('?tipo=1') ?>">Data Center Virtual</a></li>
								<li><a href="<?php \Core\Router::url('?tipo=3') ?>">Otros</a></li>
								
								<!-- <li><a href=" <?php \Core\Router::url('?tipo=4') ?>">Demos</a></li>
								<li><a href="<?php \Core\Router::url('?tipo=5') ?>">Proximamente</a></li> -->
    							<li><a href="https://cntempresas.com/">Empresas</a></li>
    						</ul>
    					</nav>
    				</div>
    				<div class="col-md-1 cartCol">
						<?php if(\Core\Session::get('sivoz_auth')): ?>
    					<a href="<?php \Core\Router::url('carrito') ?>" class="cart">
							<?php if(\Core\Session::has('cart')): ?>

    						<span class="count"><?php echo count((array) \Core\Session::get('cart')) ?></span>
							<?php endif ?>
    						<i class="icofont icofont-cart-alt"></i>
    					</a>
						<?php else: ?>
						<a href="<?php \Core\Router::url('carrito') ?>" class="cart">
							<?php if(\Core\Session::has('cart')): ?>
						
    						<span class="count"><?php echo count((array) \Core\Session::get('cart')) ?></span>
							<?php endif ?>
    						<i class="icofont icofont-cart-alt"></i>
    					</a>
						<?php endif ?>
    				</div>
				</div>
    		</div>
    	</div>

	
		<div class="cnt-content cnt-display-container" style="max-width:1600px">
		
			<img class="slides" src="<?php \Core\Router::assets('assets/img/MCV.png') ?>" style="width:100%;  max-height: 20% ">
			<img class="slides" src="<?php \Core\Router::assets('assets/img/VCD.png') ?>" style="width:100%;  max-height: 20% ">
			<img class="slides" src="<?php \Core\Router::assets('assets/img/OTROS.png') ?>" style="width:100%;  max-height: 20% ">
			<div class="cnt-center cnt-container cnt-section cnt-large cnt-text-white cnt-display-bottommiddle" style="width:100%">
				<div class="cnt-left cnt-hover-text-khaki" onclick="presionarDivs(-1)">&#10094;</div>
				<div class="cnt-right cnt-hover-text-khaki" onclick="presionarDivs(1)">&#10095;</div>
				<span class="cnt-badge demo cnt-border cnt-transparent cnt-hover-white" onclick="actualDiv(1)"></span>
				<span class="cnt-badge demo cnt-border cnt-transparent cnt-hover-white" onclick="actualDiv(2)"></span>
				<span class="cnt-badge demo cnt-border cnt-transparent cnt-hover-white" onclick="actualDiv(3)"></span>
  			</div>
		</div>
		<script>
			var indice = 0;
			var slideIndex = 0;
			//mostrarDivs(indice);
			mostrarDivsAutomatico();

			function presionarDivs(n) {
				mostrarDivs(indice += n);
			}

			function actualDiv(n) {
				mostrarDivs(indice = n);
			}

			function mostrarDivs(n) {
				var i;
				var x = document.getElementsByClassName("slides");
				var dots = document.getElementsByClassName("demo");
				if (n > x.length) {indice = 1}    
				if (n < 1) {indice = x.length}
				for (i = 0; i < x.length; i++) {
					x[i].style.display = "none";  
				}
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" cnt-white", "");
				}
				x[indice-1].style.display = "block";  
				dots[indice-1].className += " cnt-white";
			
			}
			function mostrarDivsAutomatico() {
				var i;
				var slides = document.getElementsByClassName("slides");
				var dots = document.getElementsByClassName("demo");
				for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";  
				}
				slideIndex++;
				if (slideIndex > slides.length) {slideIndex = 1}    
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" cnt-white", "");
				}
				slides[slideIndex-1].style.display = "block";  
				dots[slideIndex-1].className += " cnt-white";
				setTimeout(mostrarDivsAutomatico, 3000); // Change image every 2 seconds
			}
			
		</script>
    </header>
    <!-- ======= /1.01 Header Area ====== -->
