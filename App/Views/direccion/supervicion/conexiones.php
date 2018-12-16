<?php \Core\View::render('master.header', ['title' => 'Conexiones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Areas</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Tipo</th>
										<th>Cartera</th>
										<th>Usuario</th>
										<th>Fecha de login</th>
										<th>Tiempo de conexión</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($firmas as $firma): ?>
									<tr>
										<td><?php echo $firma->tipo ?></td>
										<td><?php echo $firma->cartera_nombre ?></td>
										<td><?php echo $firma->usuario_nombre ?></td>
										<td><?php echo $firma->fecha ?></td>
										<td timeago="<?php echo $firma->fecha ?>"><?php echo \Core\Helper::time_elapsed_string($firma->fecha) ?></td>
										<td>
											<?php if($firma->usuario == 1): ?>
											<?php else: ?>
											<?php if($firma->tipo == 'Usuario'): ?>
											<a data-close-session="<?php echo $firma->cartera . '|' . $firma->usuario . '|' . $firma->fecha .'|usuario' ?>" class="btn btn-primary">Cerrar sesión</a>
											<?php elseif($firma->tipo == 'Cliente'): ?>
											<a data-close-session="<?php echo $firma->cartera . '|' . $firma->usuario . '|' . $firma->fecha .'|cliente' ?>" class="btn btn-primary">Cerrar sesión</a>
											<?php endif ?>
											<?php endif ?>
										</td>
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
<?php \Core\View::render('master.footer', ['scripts' => [
	'assets/scripts/conexiones.js'
]]) ?>
		