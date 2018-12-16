<?php \Core\View::render('master.header', ['title' => 'Usuarios']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra un nuevo usuario</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('mantenimiento/create-user') ?>" id="user-form" data-type="add">
								<div class="col-sm-4">
									<div class="form-group">
										<input class="form-control" data-required="true" name="nombre" type="text" placeholder="Nombre">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<input class="form-control" data-required="true" name="apellidos" type="text" placeholder="Apellidos">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<input class="form-control" data-type="username" data-required="true" name="usuario" type="text" placeholder="Nombre de Usuario">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<input class="form-control" data-type="email" data-required="true" name="correo" type="text" placeholder="Correo electrónico">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input data-required="true" name="vigencia" value="<?php echo date('Y-m-d') ?>" class="form-control" placeholder="Fecha de vencimiento" type="date">
										</div>
									</div>
								</div>
								<div class="col-sm-4" style="padding-top: 0.25%;">
                                    <label for="" class="col-sm-7" >
										Envio de notificaciones
                                    </label>
                                    <label class="fancy-radio col-sm-5">
                                        <input  data-required="false" data-name="notificacion" name="notificacion" id="notificacion" type="checkbox" class="ng-pristine ng-untouched ng-valid ng-empty">
                                    </label>
                                </div>
								<div class="col-sm-6">
									<div class="form-group">
									<div class="input-group">
										<input data-required="true" data-type="password" class="form-control" name="password" type="password" placeholder="Contraseña">
										<span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>

										</div>
									
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
									<div class="input-group">
										<input data-required="true" data-same="password" class="form-control" name="password_conf" type="password" placeholder="Confirmar Contraseña">
										<span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>

									</div>	
									</div>

								</div>
								<div class="col-sm-4">
									<select data-required="true" name="area" id="area" class="form-control">
										<option value="NA">Area</option>
										<?php foreach($areas as $area): ?>
										<option value="<?php echo $area->id ?>"><?php echo $area->nombre ?></option>
										<?php endforeach ?>
									</select>
									<br>
								</div>
								<div class="col-sm-4">
									<select data-required="true" name="permiso" id="permiso" class="form-control">
										<option value="NA">Permiso</option>
									</select>
									<br>
								</div>
								<div class="col-sm-4">
									<select data-required="true" name="estatus" class="form-control">
										<option value="NA">Estatus</option>
										<option value="1">Activo</option>
										<option value="0">Inactivo</option>
									</select>
									<br>
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
							<h3 class="panel-title">Gestiones</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Usuario</th>
										<th>Area</th>
										<th>Permiso</th>
										<th>Correo</th>
										<th>Vigencia</th>
										<th>Estatus</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($users as $user): ?>
									<tr>
										<td><?php echo $user->nombre . ' ' . $user->apellidos ?></td>
										<td><?php echo $user->usuario ?></td>
										<td><?php echo $user->area ?></td>
										<td><?php echo $user->permiso ?></td>
										<td><?php echo $user->correo ?></td>
										<td><?php echo $user->vigencia ?></td>
										<td><?php echo ($user->estatus == 1 ? 'Activo' : 'Inactivo') ?></td>
										<td><a data-edit="edit" data-id="<?php echo $user->id ?>" class="btn btn-primary">Editar</a></td>
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
	'assets/scripts/usuarios.js'
]]) ?>
		