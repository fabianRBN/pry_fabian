<?php \Core\View::render('master.header', ['title' => 'Productos']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<?php foreach($products as $product): ?>
						<div class="col-md-4">
							<!-- PANEL DEFAULT -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">
										<?php echo $product->producto->nombre ?> 
										<span class="label label-info">
										<?php echo '$' . number_format($product->producto->precio, 2) ?>
										<?php if($product->producto->forma_pago == 0): ?>
										/dia
										<?php elseif($product->producto->forma_pago == 1): ?>
										/semana
										<?php elseif($product->producto->forma_pago == 2): ?>
										/quincena
										<?php elseif($product->producto->forma_pago == 3): ?>
										/mes
										<?php elseif($product->producto->forma_pago == 4): ?>
										/año
										<?php endif ?>
										</span>
									</h3>
									<br>
                                    <small>Fecha inicio: &nbsp;&nbsp;<?php echo date('Y-m-d',strtotime($product->fecha_inicio)) ?></small> <br>
                                    <small>Fecha fin: &nbsp;&nbsp;<?php echo date('Y-m-d',strtotime($product->fecha_fin)) ?></small> <br>
									<small>Estatus: &nbsp;&nbsp;<?php echo \App\Models\Estatus::calculate($product->estatus,'servicio') ?></small>
									<!-- <div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									</div> -->
								</div>
								<div class="panel-footer">
									<a href="<?php echo \Core\Router::url('administracion/servicio?id=' . $product->id) ?>" type="button" class="btn btn-default btn-block"><i class="fa fa-edit"></i> Administrar </a>
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
		