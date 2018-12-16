<?php \Core\View::render('master.header', ['title' => 'Suscripciones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Clientes</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Cliente</th>
										<th>Servicio</th>
										<th>Estatus</th>
										<th>Total</th>
										<th>Fecha de pago</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($servicios as $servicio): ?>
									<tr>
										<td><?php echo $servicio->cliente ?></td>
										<td><?php echo $servicio->servicio ?></td>
										<td>
											<?php echo \App\Models\Estatus::calculate($servicio->estatus,'servicio') ?>
										</td>
										<td><?php echo '$'.number_format($servicio->total,2) ?></td>
										<td><?php echo date('Y-m-d',strtotime($servicio->fecha_fin)) ?></td>
										<td><a href="<?php echo \Core\Router::url('operacion/suscripcion?id=' . $servicio->id) ?>" class="btn btn-primary">Ver</a></td>
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
<?php \Core\View::render('master.footer') ?>
		