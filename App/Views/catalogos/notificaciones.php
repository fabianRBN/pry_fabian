<?php \Core\View::render('master.header', ['title' => 'Notificaciones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra una nueva notificación</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/create-notificacion') ?>" id="notificacion-form" data-type="add">
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" name="titulo" notificacion-name="titulo" type="text" placeholder="Título">
									</div>
								</div>
                                <div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" name="comentario" notificacion-name="comentario" type="text" placeholder="Comentario">
									</div>
								</div>
								<div class="col-sm-6">
									<select data-required="true" notificacion-name="id_permiso" name="id_permiso" id="id_permiso" class="form-control">
										<option value="NA">Permiso</option>
										<?php foreach($permisos as $permiso): ?>
										<option value="<?php echo $permiso->id ?>"><?php echo $permiso->nombre ?></option>
										<?php endforeach ?>
									</select>
									<br>
								</div>
								<div class="col-sm-6">
									<select data-required="true" notificacion-name="id_estatus" name="id_estatus" id="id_estatus" class="form-control">
										<option value="NA">Estatus</option>
										<?php foreach($estatuss as $estatus): ?>
										<option value="<?php echo $estatus->id ?>"><?php echo $estatus->nombre . ': ' . $estatus->comentario ?></option>
										<?php endforeach ?>
									</select>
									<br>
								</div>
								<div class="col-sm-6">
									<select data-required="true" multiple notificacion-name="id_usuario" name="id_usuario[]" id="id_usuario" class="form-control">
										<option value="NA">Usuarios</option>
										<?php foreach($usuarios as $usuario): ?>
										<option value="<?php echo $usuario->id ?>"><?php echo $usuario->nombre ?></option>
										<?php endforeach ?>
									</select>
									<br>
								</div>
								<div class="col-sm-6" style="  padding-bottom: 1%;">
                                    <div class="form-group">
                                        <label for="" class="col-sm-6">
										Envio de correos SMTP
                                        </label>
                                        <label class="fancy-radio col-sm-6">
                                            <input  data-required="false" notificacion-name="email_smtp" name="email_smtp" id="email_smtp" type="checkbox" class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </label>
                                    </div>
                                </div>
                               
								<div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="col-sm-6">
											Envio de correos SMTP a clientes
                                        </label>
                                        <label class="fancy-radio col-sm-6">
                                            <input  data-required="false" notificacion-name="email_smtp_cliente" name="email_smtp_cliente" id="email_smtp_cliente" type="checkbox" class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </label>
                                    </div>
                                </div>

								<div class="col-sm-12">
									<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Notificaciones</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Permiso</th>
										<th>Estatus</th>
										<th>Título</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($notificaciones as $notificacion): ?>
									<tr>
										<td><?php echo $notificacion->permiso ?></td>
										<td><?php echo $notificacion->estatus . ': ' . $notificacion->comentario ?></td>
										<td><?php echo $notificacion->titulo ?></td>
										<td><a data-id="<?php echo $notificacion->id ?>" class="btn btn-primary notificaciones">Editar</a></td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<div id="url" data-url='<?php echo \App\Config::Domain ?>'></div>
<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/notificaciones.js'
]]) ?>
		