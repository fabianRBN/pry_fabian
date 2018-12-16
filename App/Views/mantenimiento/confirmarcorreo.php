<?php \Core\View::render('master.header', ['title' => 'Confirma tu correo electrónico']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">Aún no confirmas tu correo electrónico</div>
                        </div>
                        <div class="panel-body">
                            <p>
                                Para poder acceder a las funciones de nuestra plataforma deberás confirmar tu cuenta de correo electrónico
                            </p>
                            <br>
                            <input type="text" disabled value="<?php echo \Core\Session::get('sivoz_auth')->correo ?>" class="form-control">
                            <a href="<?php echo \Core\Router::url('mantenimiento/send-confirmation-email') ?>" class="btn btn-primary btn-block">Reenviar correo de confirmación</a>
                        </div>
                    </div>
                </div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		