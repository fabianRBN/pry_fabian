<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title><?php echo App\Config::Title ?> | Error 401</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/vendor/linearicons/style.css') ?>">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/main.css') ?>">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="<?php \Core\Router::assets('assets/css/demo.css') ?>">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php \Core\Router::assets('assets/img/' . App\Config::Favicon) ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php \Core\Router::assets('assets/img/' . App\Config::Favicon) ?>">
</head>

<!-- <script type="text/javascript">
	if(history.forward(1)){
		location.replace( history.forward(1) );
	}
	
	function noback(){
		window.location.hash="/";
		window.location.hash="#/"
		window.onhashchange=function(){window.location.hash="/";}
		//location.href="https://smart.cntcloud2.com";
		}
	</script>

<body onload="noback();"> -->
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
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
							<div class="header">
								<div class="logo text-center"><img width="200px" src="<?php \Core\Router::assets('assets/img/' . App\Config::Logo) ?>" alt="<?php echo App\Config::ClientName ?> Logo"></div>
                            </div>
							<div style="color:#00a0e3a6">
								<h1 class="heading">Whoops Error 401!</h1>
								<?php if(isset($_SESSION['sivoz_auth'])): ?>
									<p>No tienes permiso para realizar esta acción</p>

								<?php else: ?>
									<p>Session caducada</p>

								<?php endif ?>
								
							</div>
						</div>
						<br>
						<br>
						<br>
						<br>
						<div class="logo text-center">
						<a href="<?php echo App\Config::Domain ?>">
						<img width="50px" src="<?php \Core\Router::assets('assets/img/Home.png') ?>" title="Pagina principal" alt="<?php echo App\Config::ClientName ?> Logo">
						</a>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
