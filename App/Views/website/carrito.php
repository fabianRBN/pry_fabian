<?php \Core\View::render('website.header', ['title' => 'Carrito'])
?>
    <div class="pageTitleArea animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="pageTitle">
    					<div class="h2">Carrito</div>
    					<ul class="pageIndicate">
    						<li><a href="">Inicio</a></li>
    						<li><a href="">Carrito</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
	<?php \App\Models\Carrito::allDetalle();
?>
    <!-- ======= /2.01 Page Title Area ====== -->
    <div class="cartArea secPdngB">
    	<div class="container animated">
    		<div class="row">
    			<div class="col-sm-12">
    				<ul class="cartTable">
    					<li class="cartHead clearfix">
    						<div class="product">Producto</div>
							<div class="duration">Tipo de Pago</div>
    						<div class="price">Precio</div>
						</li>
						<?php foreach($productos as $producto): ?>
						<?php   echo "<script>console.log(  " . json_encode( $producto) . " );</script>";?>
    					<li class="singleIteam clearfix category-host"> <!-- category calss hove to use for host icon-->
    						<div class="product"><a href="<?php \Core\Router::url('remove-to-cart?producto=' . $producto->id) ?>"><span  class="closeIcon">x</span></a>
							<div class="pTxt">
								<div style="display: flex;  justify-content: space-between;">
								<div>
								<?php echo $producto->nombre ?>

		
								</div>
								<div style="margin-right: 10%;">
								
								
							
							
								<a class="" data-toggle="collapse" href="<?php echo '#'.$producto->id; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $producto->id; ?>">
								<span style="color: #00a0e3;" class="glyphicon glyphicon-menu-down"></span>
								</a>
								</div>
								</div>
								
								
							</div>
							<div class="collapse" id="<?php echo $producto->id; ?>" style="  margin-left: 10%; margin-right: 10%;  margin-top: 2%;">
								<div class=" card-body">
								<ul class="list-group list-group-flush" style="margin: 0%;">
									<?php foreach($producto->opciones as $opcion): ?> 
									<li style="list-style: none;">
									<span class="ma-ver-8" style="    font-family: Verdana,sans-serif;">
										 <?php echo $opcion->valor."  ". $opcion->nombre  ?>
									</span></li>
									<?php endforeach ?>
								
								</ul>
								</div>
								</div>
							</div>
    						<div class="price">
    							<span><span>/
								<?php if($producto->tipo_pago == 0): ?>
								diario
								<?php endif ?>
								<?php if($producto->tipo_pago == 1): ?>
								semanal
								<?php endif ?>
								<?php if($producto->tipo_pago == 2): ?>
								quincenal
								<?php endif ?>
								<?php if($producto->tipo_pago == 3): ?>
								mensual
								<?php endif ?>
								<?php if($producto->tipo_pago == 4): ?>
								anual
								<?php endif ?>
								
								</span></span>
    						</div>
    						<div class="total"><?php echo '$' . number_format($producto->precio, 2) ?></div>
						</li>
						<?php endforeach ?>
    				</ul>
    			</div>
    			<div class="col-md-5 col-md-offset-7 col-sm-12">
    				<div class="cartTotal">
    					<div class="h4 title">Total:</div>
    					<div><span class="subTotal">Subtotal:</span> <span><?php echo '$' . number_format($subtotal,2) ?></span></div>
    					<div><span class="subTotal">IVA:</span> <span><?php echo '$' . number_format($iva,2) ?></span></div>
    					<div><span class="Total">Total:</span> <span><?php echo '$' . number_format($total,2) ?></span></div>
						<?php if(\Core\Session::has('sivoz_auth')): ?>
							<a href="<?php \Core\Router::url('administracion') ?>" class="totalBtn">Cotizar <i class="icofont icofont-long-arrow-right"></i></a>
                    	<?php else: ?>
							<a href="<?php \Core\Router::url('connect') ?>" class="totalBtn">Cotizar <i class="icofont icofont-long-arrow-right"></i></a>
                    	<?php endif ?>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="sectionBar"></div>
<?php \Core\View::render('website.footer') ?>
		