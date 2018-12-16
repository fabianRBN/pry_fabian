<?php \Core\View::render('master.header', ['title' => 'Clientes']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Ventas</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Ubicación</th>
										<th>Estatus</th>
										<th>Correo</th>
										<th>Compras</th>
										<th>Fecha de registro</th>
										<th>Verificado</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($users as $user): ?>
									<tr>
										<td><?php echo $user->nombre . ' ' . $user->apellidos ?></td>
										<td><?php echo $user->ciudad . ', ' . $user->pais ?></td>
										<td>
											<?php echo \App\Models\Estatus::calculate($user->estatus,'cliente') ?>
										</td>
										<td><?php echo $user->correo ?></td>
										<td><?php echo $user->productos ?></td>
										<td><?php echo $user->fecha_registro ?></td>
										<td><?php echo ($user->verificado == 1 ? 'Si' : 'No') ?></td>
										<td><a href="<?php echo \Core\Router::url('operacion/cliente?id=' . $user->id) ?>" class="btn btn-primary">Ver</a></td>
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
	'assets/scripts/clientes.js'
]]) ?>
		