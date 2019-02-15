<?php \Core\View::render('master.header', ['title' => 'Ventas']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<?php echo "<script>console.log(".json_encode($asignaciones).")</script>" ?>
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Clientes  - Ventas</h3>
						</div>
						<div class="panel-body">

							<div class="row">
							<div class="col-md-12">
						
								<ul id="tabsJustified" class="nav nav-tabs">
									<li class="nav-item active"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase active">Pendientes</a></li>
									<li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase ">Asignados</a></li>
									<li class="nav-item"><a href="" data-target="#todos" data-toggle="tab" class="nav-link small text-uppercase ">Todos</a></li>
									
								</ul>
								<br>
								<div id="tabsJustifiedContent" class="tab-content">
									<div id="home1" class="tab-pane fade active  in">
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
											<?php foreach($historial as $carrito): ?>
											
											<?php if(in_array($carrito->estatus, $asignaciones)): ?>
											<tr>
												
													<td><?php echo $carrito->cliente ?></td>
													<td><?php echo $carrito->producto ?></td>
													<td>
														<?php echo \App\Models\Estatus::calculate($carrito->estatus,'carrito') ?>
													</td>
													<td><?php echo date('Y-m-d', strtotime( $carrito->fecha_compra)) ?></td>
													<td><a href="<?php echo \Core\Router::url('operacion/carrito?id=' . $carrito->id) ?>"  onclick="return waitingDialog.show();" class="btn btn-primary">Ver</a></td>
												
											</tr>
											<?php endif ?>
											<?php endforeach ?>
										</tbody>
									</table>
									
									</div>
									<div id="profile1" class="tab-pane ">
									
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
											<?php foreach($historial as $carrito): ?>
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

									<div id="todos" class="tab-pane ">
									
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
				
							
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<div id="url" data-url='<?php echo \App\Config::Domain ?>'></div>
<?php \Core\View::render('master.footer') ?>
		