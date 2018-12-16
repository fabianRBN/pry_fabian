<?php \Core\View::render('master.header', ['title' => 'Ventas']) ?>
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
										<th>Empresa</th>
										<th>Producto</th>
										<th>Estatus</th>
										<th>Suscripción</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($carritos as $carrito): ?>
									<tr>
										<td><?php echo $carrito->cliente ?></td>
										<td><?php echo $carrito->producto ?></td>
										<td>
											<?php echo \App\Models\Estatus::calculate($carrito->estatus,'carrito') ?>
										</td>
										<td><?php echo date('Y-m-d', strtotime( $carrito->fecha_compra)) ?></td>
										<td><a href="<?php echo \Core\Router::url('operacion/carrito?id=' . $carrito->id) ?>"  onclick="return waitingDialog.show();" class="btn btn-primary">Ver</a></td>
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
		