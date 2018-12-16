<?php \Core\View::render('master.header', ['title' => 'Servicios']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
									<div class="panel-title">Tipo de membresía</div>
								</div>
								<div class="panel-body">
									<p class="text-muted">Selecciona el tipo de membresía que deseas contratar</p>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<br>
							<br>
						</div>
						<?php foreach($servicios as $servicio): ?>
						<div class="col-md-4">
							<!-- PANEL DEFAULT -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">
										<?php echo $servicio->nombre ?> 
										<span class="label label-success">
										<?php echo '$' . number_format($servicio->precio, 2) ?>
										<?php if($servicio->forma_pago == 1): ?>
										/ pago único
										<?php elseif($servicio->forma_pago == 2): ?>
										/dia
										<?php elseif($servicio->forma_pago == 3): ?>
										/semana
										<?php elseif($servicio->forma_pago == 4): ?>
										/quincena
										<?php elseif($servicio->forma_pago == 5): ?>
										/mes
										<?php elseif($servicio->forma_pago == 6): ?>
										/año
										<?php endif ?>
										</span>
									</h3>
									<!-- <div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									</div> -->
								</div>
								<div class="panel-body">
									<?php echo $servicio->descripcion ?>
								</div>
								<div class="panel-footer">
									<a href="<?php echo \Core\Router::url('tienda/servicio?id=' . $servicio->id) ?>" type="button" class="btn btn-default btn-block"><i class="fa fa-shopping-cart"></i> Contratar </a>
								</div>
							</div>
							<!-- END PANEL DEFAULT -->
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		