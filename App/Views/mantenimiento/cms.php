<?php \Core\View::render('master.header', ['title' => 'CMS']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra una nueva ruta</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('mantenimiento/create-route') ?>" id="route-form" data-type="add">
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" route-name="nombre" name="nombre" type="text" placeholder="Nombre">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" route-name="ruta" name="ruta" type="text" placeholder="Ruta">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-type="routename" route-name="controlador" data-required="true" name="controlador" type="text" placeholder="Controlador">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" route-name="accion" name="accion" type="text" placeholder="Método">
									</div>
								</div>
                                <div class="col-sm-12">
                                <label for="">Permisos</label>
                                    <select class="form-control" name="permisos" route-name="permisos" data-required="true" multiple>
                                        <option value="all">Todos</option>
                                        <?php foreach($permisos as $permiso): ?>
										<option value="<?php echo $permiso->id ?>"><?php echo $permiso->nombre ?></option>
										<?php endforeach ?>
                                    </select>
                                    <br>
                                </div>
								<div class="col-sm-6">
                                    <label for="">Grupo</label>
									<select data-required="true" name="grupo" route-name="grupo" id="grupo" class="form-control">
										<?php if(\Core\Session::get('sivoz_auth')->permiso == 1): ?>
										<option value="0">Rest api</option>
										<?php endif ?>
										<?php foreach($grupos as $grupo): ?>
										<option value="<?php echo $grupo->id ?>"><?php echo $grupo->nombre ?></option>
										<?php endforeach ?>
									</select>
									<br>
								</div>
                                <div class="col-sm-6">
                                    <label for="">Estatus</label>
                                    <select data-required="true" name="activo" route-name="activo" id="activo" class="form-control">
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
                <div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra una nuevo grupo</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('mantenimiento/create-group') ?>" data-type="add" id="group-form">
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" group-name="nombre" name="nombre" type="text" placeholder="Nombre">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" group-name="orden" value="<?php echo count($grupos) + 1 ?>" name="orden" type="text" placeholder="Orden">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
                                        <label for="">Icono</label>
										<input class="form-control" data-type="routename" group-name="icono" data-required="true" name="icono" type="text" placeholder="lnr lnr-layers">
									</div>
								</div>
                                <div class="col-sm-6">
                                    <label for="">Estatus</label>
                                    <select data-required="true" name="activo" group-name="activo" id="activo" class="form-control">
										<option value="1">Activo</option>
										<option value="0">Inactivo</option>
									</select>
                                    <br>
                                </div>
                                <div class="col-sm-12">
                                <label for="">Permisos</label>
                                    <select name="permisos" class="form-control" group-name="permisos" data-required="true" multiple>
                                        <option value="all">Todos</option>
                                        <?php foreach($permisos as $permiso): ?>
										<option value="<?php echo $permiso->id ?>"><?php echo $permiso->nombre ?></option>
										<?php endforeach ?>
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
							<h3 class="panel-title">Grupos</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Permisos</th>
										<th>Orden</th>
										<th>Rutas</th>
										<th>Estatus</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($grupos as $grupo): ?>
									<tr>
										<td><?php echo $grupo->nombre?></td>
										<td><?php echo $grupo->permisos ?></td>
										<td><?php echo $grupo->orden ?></td>
										<td><?php echo $grupo->rutas ?></td>
										<td><?php echo ($grupo->activo == 1 ? 'Activo' : 'Inactivo') ?></td>
										<td><a data-edit-group="edit" data-id="<?php echo $grupo->id ?>" class="btn btn-primary">Editar</a></td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Rutas</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Permisos</th>
										<!-- <th>Grupo</th> -->
										<th>Ruta</th>
										<th>Controlador</th>
										<th>Método</th>
										<th>Estatus</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($routes as $route): ?>
									<tr>
										<td><?php echo $route->nombre?></td>
										<td><?php echo $route->permisos ?></td>
										<!-- <td><?php echo $route->grupo_nombre ?></td> -->
										<td><?php echo $route->ruta ?></td>
										<td><?php echo $route->controlador ?></td>
										<td><?php echo $route->accion ?></td>
										<td><?php echo ($route->activo == 1 ? 'Activo' : 'Inactivo') ?></td>
										<td><a data-id="<?php echo $route->id ?>" class="btn btn-primary routes">Editar</a></td>
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
	'assets/scripts/cms.js'
]]) ?>
		