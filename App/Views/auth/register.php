<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title><?php echo App\Config::Title ?> | Registrate</title>
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
	<br>
	<br>


	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><a href="<?php Core\Router::url('') ?>"><img width="200px" src="assets/img/<?php echo App\Config::Logo ?>" alt="<?php echo App\Config::ClientName ?> Logo"></a></div>
								<p class="lead">Registrate</p>
							</div>
							<form class="form-auth-large" method="post" action="<?php Core\Router::url('register_post') ?>">
								
								
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Nombre(s)</label>
									<input required type="nombre" name="nombre" class="form-control" id="signin-nombre" value="<?php echo Core\Session::flash('nombre_value_input') ?>" placeholder="Nombre(s)">
									<p class="text-danger">
										<?php echo Core\Session::flash('nombre_error') ?>
									</p>
								</div>
                                <div class="form-group">
									<label for="signin-email" class="control-label sr-only">Apellidos</label>
									<input required type="apellidos" name="apellidos" class="form-control" id="signin-apellidos" value="<?php echo Core\Session::flash('apellidos_value_input') ?>" placeholder="Apellidos">
									<p class="text-danger">
										<?php echo Core\Session::flash('apellidos_error') ?>
									</p>
								</div>

								<div class="form-group">
									<label for="signin-ruc" class="control-label sr-only">RUC</label>
									<input required type="number"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="13" name="ruc" class="form-control" id="signin-ruc" value="<?php echo Core\Session::flash('ruc_value_input') ?>" placeholder="RUC">
									<p class="text-danger">
										<?php echo Core\Session::flash('ruc_error') ?>
									</p>
								</div>

								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Correo electrónico</label>
									<input required type="correo" name="correo" class="form-control" id="signin-correo" value="<?php echo Core\Session::flash('correo_value_input') ?>" placeholder="Correo electrónico">
									<p class="text-danger">
										<?php echo Core\Session::flash('correo_error') ?>
									</p>
								</div>

                                
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Contraseña</label>
									<input required type="password" id="password" autocomplete="off"  name="password" class="form-control" id="signin-password" value="" placeholder="Contraseña">
									<div style="text-align: left; margin: 10px;">
										<input type="checkbox" onclick="showpass()" style=" margin-right: 15px;"><label> Mostrar Contraseña </label>
									</div>
									<p  class="text-danger">
										<?php echo Core\Session::flash('password_error') ?>
									</p>
								</div>

								<div class="form-group">
									<select required name="tipo" id="tipo" class="form-control">
										<option value="">Tipo de cliente</option>
										<?php foreach($tipo_clientes as $tc): ?>
										<option value="<?php echo $tc->id ?>"><?php echo $tc->nombre ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<select required name="sector" id="sector" class="form-control">
										<option value="">Sector</option>
										<?php foreach($sectores as $sector): ?>
										<option value="<?php echo $sector->id ?>"><?php echo $sector->nombre ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Empresa</label>
									<input required type="empresa" name="empresa" class="form-control" id="signin-empresa" value="<?php echo Core\Session::flash('empresa_value_input') ?>" placeholder="Empresa">
									<p class="text-danger">
										<?php echo Core\Session::flash('empresa_error') ?>
									</p>
								</div>
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Teléfono</label>
									<input required type="telefono" name="telefono" class="form-control" id="signin-telefono" value="<?php echo Core\Session::flash('telefono_value_input') ?>" placeholder="Teléfono">
									<p class="text-danger">
										<?php echo Core\Session::flash('telefono_error') ?>
									</p>
								</div>
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Dirección</label>
									<input required type="direccion" name="direccion" class="form-control" id="signin-direccion" value="<?php echo Core\Session::flash('direccion_value_input') ?>" placeholder="Dirección">
									<p class="text-danger">
										<?php echo Core\Session::flash('direccion_error') ?>
									</p>
								</div>
                                <div class="form-group">
									<input required type="hidden" name="pais">
									<div id="pais"></div>
								</div>
                                <div class="form-group">
									<input required type="hidden" name="ciudad">
									<div id="ciudad"></div>
								</div>
                                

								<input  type="hidden" name="tokenCSRF" value=" <?php echo strval(\Core\Session::createToken() )?>" >

								<button type="submit" class="btn btn-primary btn-lg btn-block">Crear cuenta</button>
								<br>
								<br>
								<br>
							</form>
						</div>
					</div>
					<div class="right large" style="height: 850px !important;     background-image: url(../../assets/img/login-bg3.png) !important;">
						<div class="overlay"></div>
						<<!-- div class="content text">
							<h1 class="heading"><?php echo \App\Config::ClientName ?></h1>
							<p><?php echo \App\Config::Description ?></p>
						</div> -->
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php \Core\Router::assets('assets/vendor/jquery/jquery.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/config.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/autocomplete.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/register.js') ?>"></script>
	
	<!-- END WRAPPER -->
</body>

</html>
