<!DOCTYPE html>
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
								<p class="lead">Recupera tu contraseña</p>
							</div>
							<?php if(\Core\Session::has('reset_password') == false) : ?>
							<form class="form-auth-small" method="post" action="<?php \Core\Router::url('forgot_post') ?>">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Correo electrónico</label>
									<input type="email" name="email" class="form-control" id="signin-email" value="" placeholder="Email">
									<p class="text-danger">
										<?php echo Core\Session::flash('email_error') ?>
									</p>
								</div>
								<input id="tokenCSRF"  type="hidden" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >
								<button type="submit" onclick="return waitingDialog.show();" class="btn btn-primary btn-lg btn-block">Recuperar</button>
							</form>
							<?php else : ?>
							<p><?php echo \Core\Session::flash('reset_password') ?></p>
							<?php endif; ?>
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

	<script src="<?php \Core\Router::assets('website/js/jquery.1.11.3.min.js') ?>"></script> <!-- jQuery -->
    <script src="<?php \Core\Router::assets('website/js/bootstrap.min.js') ?>"></script> <!-- Bootstrap -->
    <script src="<?php \Core\Router::assets('website/js/owl.carousel.min.js') ?>"></script> <!-- owlCarousel -->
    <script src="<?php \Core\Router::assets('website/js/waypoints.min.js') ?>"></script> <!-- waypoint -->
    <script src="<?php \Core\Router::assets('website/js/active.js') ?>"></script> <!-- active js -->
    <script src="<?php \Core\Router::assets('assets/scripts/moment.js') ?>"></script>
    <script src="<?php \Core\Router::assets('assets/vendor/toastr/toastr.js') ?>"></script>

    <script src="<?php \Core\Router::assets('assets/scripts/config.js') ?>"></script>
</body>

</html>
