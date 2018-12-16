<?php \Core\View::render('master.header', ['title' => 'Productos']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content" >
				<div class="container-fluid">
					<div class="row">
					
						<?php foreach($products as $product): ?>
						<?php if(intval($product->venta) > 0 && intval($product->activo) > 0 ):?>
						<div class="col-md-4" >
							<!-- PANEL DEFAULT -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">
										<?php echo $product->nombre ?>
										<br> 
										<span class="label label-info">
										<?php echo '$' . number_format($product->precio, 2) ?>
										<?php if($product->tipo_pago == 0): ?>
										/dia
										<?php elseif($product->tipo_pago == 1): ?>
										/semana
										<?php elseif($product->tipo_pago == 2): ?>
										/quincena
										<?php elseif($product->tipo_pago == 3): ?>
										/mes
										<?php elseif($product->tipo_pago == 4): ?>
										/año
										<?php endif ?>
										</span>
									</h3>
									<!-- <div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									</div> -->
								</div>
								<div class="panel-body">
									<!--llamamos la clase expandable adicional podemos darle mas estilo pero ese no es el foco del tutorial-->
									<div class="expandable">
									<!-- Nuestro parrafo a mostrar-->
									<p><?php echo $product->descripcion ?></p>
									</div>
								</div>
								<div class="panel-footer">
								<a href="#" onclick= <?php echo "productos(".$product->id ."); return false;" ?> type="button" class="btn btn-default btn-block"><i class="fa fa-shopping-cart"></i> Más información </a>
								</div>
							</div>
							<!-- END PANEL DEFAULT -->
						</div>
						<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
				<input id="tokenCSRF"  type="hidden" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >

			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		