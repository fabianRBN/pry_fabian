<?php \Core\View::render('master.header', ['title' => 'Productos']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
					<?php if(sizeof($products) == 0){?>
						<a href="<?php \Core\Router::url('tienda/productos') ?>">Ir a la tienda</a></li>
					<?php } ?>
						<?php foreach($products as $product): ?>
						<div class="col-md-4">
							<!-- PANEL DEFAULT -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">
										<?php echo $product->producto->nombre ?> 
										<br>
										<span class="label label-info">
										<?php echo '$' . number_format($product->total, 2) ?>
										<?php if($product->producto->tipo_pago == 0): ?>
										/dia
										<?php elseif($product->producto->tipo_pago == 1): ?>
										/semana
										<?php elseif($product->producto->tipo_pago == 2): ?>
										/quincena
										<?php elseif($product->producto->tipo_pago == 3): ?>
										/mes
										<?php elseif($product->producto->tipo_pago == 4): ?>
										/año
										<?php endif ?>
										</span>
									</h3>
									<br>
									<small>Próximo pago: &nbsp;&nbsp;<?php echo date('Y-m-d',strtotime($product->fecha_pago)) ?></small> <br>
									<small>Estatus: &nbsp;&nbsp;<?php echo \App\Models\Estatus::calculate($product->estatus,'carrito') ?></small>
									<!-- <div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									</div> -->
								</div>
								<div class="panel-body">
									<?php foreach($product->opciones as $opcion): ?>
                                    <div>
                                        <span><?php echo $opcion->nombre ?></span>: 
                                        <br> 
                                        <span class="label label-default" id="<?php echo \Core\Helper::slugify($opcion->nombre) ?>">
                                        <?php echo $opcion->value ?>
                                        </span>
                                    </div>
                                    <?php endforeach ?>
								</div>
								<div class="panel-footer">
									<a href="<?php echo \Core\Router::url('administracion/carrito?id=' . $product->id) ?>" type="button" class="btn btn-default btn-block"><i class="fa fa-edit"></i> Administrar </a>
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
		