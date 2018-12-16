<?php \Core\View::render('master.header', ['title' => 'Permisos']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra un nuevo Rol</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/create-permiso') ?>" id="permiso-form" data-type="add">
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" data-required="true" name="nombre" permiso-name="nombre" type="text" placeholder="Nombre">
									</div>
								</div>
								<div class="col-sm-6">
									<select data-required="true" permiso-name="area" name="area" id="area" class="form-control">
										<option value="NA">Area</option>
										<?php foreach($areas as $area): ?>
										<option value="<?php echo $area->id ?>"><?php echo $area->nombre ?></option>
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
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra una nueva area</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/create-area') ?>" id="area-form" data-type="add">
								<div class="col-sm-12">
									<div class="form-group">
										<input class="form-control" area-name="nombre" data-required="true" name="nombre" type="text" placeholder="Nombre">
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
							<h3 class="panel-title">Areas</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Area</th>
										<th>Roles</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($areas as $area): ?>
									<tr>
										<td><?php echo $area->nombre ?></td>
										<td><?php echo $area->permisos ?></td>
										<td><a data-id="<?php echo $area->id ?>" class="btn btn-primary areas">Editar</a></td>
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
							<h3 class="panel-title">Roles</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Permiso</th>
										<th>Area</th>
										<th>Usuarios</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($permisos as $permiso): ?>
									<tr>
										<td><?php echo $permiso->nombre ?></td>
										<td><?php echo $permiso->area ?></td>
										<td><?php echo $permiso->usuarios ?></td>
										<td><a data-id="<?php echo $permiso->id ?>" class="btn btn-primary permisos">Editar</a></td>
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
	'assets/scripts/permisos.js'
]]) ?>
		