<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo App\Config::Title ?> | <?php echo $title ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/fonts/stylesheet.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">

	
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/linearicons/style.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/chartist/css/chartist-custom.css') ?>">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/main.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/jquery.flowchart.min.css') ?>">
	<link  href="<?php \Core\Router::assets('assets/js/flujo/jquery.flowchart.min.css') ?>">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/demo.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/scripts/editor/ui/trumbowyg.min.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/toastr/toastr.css') ?>">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">




	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php \Core\Router::assets('assets/img/favicon.png')?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php \Core\Router::assets('assets/img/favicon.png')?>">

		

	<meta http-equiv="Expires" content="0" /> 
	<meta http-equiv="Pragma" content="no-cache" />
<!-- 	<script type="text/javascript">
	if(history.forward(1)){
		location.replace( history.forward(1) );
	}
	function noback(){
		window.location.hash="/";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){window.location.hash="/";}
		}
	</script>
</head>

<body onload="noback();"> -->
<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<?php if(isset($_SESSION['CREATED'])): ?>
		<input type="hidden" id="timevalue" name="timevalue" value=<?php  echo json_encode($_SESSION['CREATED']) ?> >
		<?php else:?>
		<input type="hidden" id="timevalue" name="timevalue" value="0" >
		<?php endif?>
			<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="/"><img id="imageid" height="50px" src="<?php \Core\Router::assets('assets/img/logo-dark.png') ?>"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
					
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
					
						<li class="dropdown">
							<a href="#" id="notificaciones-list" data-notificaciones="<?php echo count(\App\Models\Alert::byUser()) ?>" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger" style="    background-color: #5bc0de;" id="notify-badge"><?php echo count(\App\Models\Alert::byUser()) ?></span>
							</a>
							<ul class="dropdown-menu notifications">
								<?php foreach(\App\Models\Alert::byUser() as $notification): ?>
								<li><a href="<?php \Core\Router::url($notification->url) ?>" class="notification-item">
									<h6><?php echo $notification->titulo ?></h6>
									<span class="dot bg-warning"></span><?php echo $notification->comentario ?></a>
								</li>
								<?php endforeach ?>
								<li><a href="<?php \Core\Router::url('operacion/notificaciones') ?>" class="more">Ver todas las notificaciones</a></li>
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								
								<span> <?php echo \Core\Session::get('sivoz_auth')->nombre ." ".\Core\Session::get('sivoz_auth')->apellidos  ?>  
								</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo \Core\Router::url('logout') ?>" ><i class="lnr lnr-exit"></i> <span>Cerrar sesión</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<?php $grupos = \App\Models\Grupo::all() ?>
						<?php $menus = \App\Models\Menu::all() ?>
						<?php foreach($grupos as $grupo): ?>
						<?php if(\Core\Session::canSee(explode(',',$grupo->permisos)) == true) : ?>
						<li>
							<a href="#<?php echo strtolower($grupo->nombre) ?>" data-toggle="collapse" class="collapsed"><i class="<?php echo $grupo->icono ?>"></i> <span><?php echo $grupo->nombre ?></span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="<?php echo strtolower($grupo->nombre) ?>" class="collapse ">
								<ul class="nav">
									<?php foreach($menus as $menu): ?>
									<?php if($menu->grupo == $grupo->id): ?>

									<?php if(\Core\Session::canSee(explode(',',$menu->permisos)) == true) : ?>
									<?php if($menu->activo != 0) : ?>
										<li><a href="<?php \Core\Router::url($menu->ruta) ?>" class=""><?php echo $menu->nombre ?></a></li>
									<?php endif ?>
									<?php endif ?>
									<?php endif ?>
									<?php endforeach ?>
								</ul>
							</div>
						</li>
						<?php endif; ?>
						<?php endforeach ?>
						<li><a href="<?php \Core\Router::url('logout') ?>" class=""><i class="lnr lnr-exit"></i> <span>Cerrar sesión</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->


	
		<!-- MAIN -->