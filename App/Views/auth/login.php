<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title><?php echo App\Config::Title ?> | Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/<?php echo App\Config::Favicon ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/<?php echo App\Config::Favicon ?>">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
						<br>
						<br>
						<br>
							<div class="header">
								<div class="logo text-center"><a href="<?php Core\Router::url('') ?>"><img width="200px" src="assets/img/<?php echo App\Config::Logo ?>" alt="<?php echo App\Config::ClientName ?> Logo"></a></div>
								<p class="lead">Inicia sesión en tu cuenta</p>
							</div>
							<form class="form-auth-small" method="post" action="<?php Core\Router::url('login') ?>">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Correo electrónico</label>
									<input type="email" name="email" class="form-control" id="signin-email" value="<?php echo Core\Session::flash('email_value_input') ?>" placeholder="Email">
									<p class="text-danger">
										<?php echo Core\Session::flash('email_error') ?>
									</p>
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Contraseña</label>
									<input type="password" autocomplete="off" name="password" class="form-control" id="signin-password" value="" placeholder="Password">
									<input  type="hidden" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >

									<p  class="text-danger">
										<?php echo Core\Session::flash('password_error') ?>
									</p>
								</div>
								<?php  if(isset($_SESSION['intentos'])): ?>
									<?php   
										
										if(isset($_SESSION['intentosfecha'])){

										
											$fecha= $_SESSION['intentosfecha'];
											$hoy = getdate();
											if($fecha['hours']< $hoy['hours'] || $fecha['minutes']< $hoy['minutes'] ||  ($hoy['minutes'] -$fecha['minutes'] )> 30 ){
												$_SESSION['intentos']= 0;
												$_SESSION['intentosfecha']=getdate();
											}
										}
									?>
									<?php if($_SESSION['intentos'] > 2): ?>
									<button type="button" class="btn btn-primary btn-lg btn-block"  onclick='location.reload(true);'>Espera un momento </button>
									<?php echo '<h4>Intentos de login alcanzados! </h4>' ?>
								<?php else:?>
								<button type="submit" class="btn btn-primary btn-lg btn-block">Iniciar Sesión</button>
									<?php endif?>
								<?php else:?>
								<button type="submit" class="btn btn-primary btn-lg btn-block">Iniciar Sesión</button>

								<?php endif?>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="<?php Core\Router::url('forgot') ?>">Olvidaste tu contraseña?</a></span>
									<div class="h5">Aún no tienes una cuenta?</div>
    								<a href="<?php \Core\Router::url('register') ?>" class="signUp">Registrate aquí.</a>
								</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<!-- <div class="content text">
							<h1 class="heading"><?php echo \App\Config::ClientName ?></h1>
							<p><?php echo \App\Config::Description ?></p>
						</div> -->
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
