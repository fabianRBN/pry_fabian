<?php \Core\View::render('website.header', ['title' => 'Productos']) ?>
    <!-- ======= 1.05 Pricing Area ====== -->
    <div class="pricingArea animated">
    	<div class="container">
    		<div class="row">
				<div class="price clearfix">
					<?php 
						usort($productos, function($a, $b)
						{
							return $a->orden > $b->orden;
						});
					foreach($productos as $producto): ?>
					<div class="col-md-3 priceCol col-sm-5">
						<div class="singlePrice">
							<div class="priceHead">
								<span class="priceTitle"><?php echo $producto->nombre ?></span>
								<div class="priceImg">
								<img src=<?php echo $producto->imagen ?> alt="Red dot" />
									<!--<img src="<?php \Core\Router::assets('website/img/icon/menu-img.png') ?>" alt="">-->
								</div>
								<h6 style=" color: #738191;"> Contrátalo desde:</h6>
								<div class="currency" > $<?php echo number_format($producto->precio,2) ?><span>/
								<?php 
						
								
								if($producto->tipo_pago == 0): ?>
								día
								<?php endif ?>
								<?php if($producto->tipo_pago == 1): ?>
								semana
								<?php endif ?>
								<?php if($producto->tipo_pago == 2): ?>
								quincena
								<?php endif ?>
								<?php if($producto->tipo_pago == 3): ?>
								mes
								<?php endif ?>
								<?php if($producto->tipo_pago == 4): ?>
								año
								<?php endif ?>
								
								</span></div>
							</div>
							<ul class="priceBody">
								<?php foreach($producto->opciones as $opcion): ?>
								<?php if(isset($opcion->display)): ?>
								<?php if($opcion->display !== false): ?>
								<?php if($opcion->display == 'no'): ?>
								<?php if($opcion->tipo == 2): ?>
								<?php else: ?>
								<li data-display="no">&nbsp;</li>
								<?php endif ?>
								<?php else: ?>
								<li><i class="icofont icofont-ui-check"></i><?php echo $opcion->display ?></li>
								<?php endif ?>
								<?php endif ?>
								<?php else: ?>
								<li data-display="no-isset">&nbsp;</li>
								<?php endif ?>
								<?php endforeach ?>
							</ul>
							<?php if(\Core\Session::has('sivoz_auth')): ?>
							<input type="button" onclick="btnPassProducto(<?php echo $producto->id ?>);" class="priceBtn Btn" value="Cotizar"></a>							
							<?php else: ?>
							
							<input type="button" onclick="btnPassProducto(<?php echo $producto->id ?>);" class="priceBtn Btn" value="Cotizar"></a>
							
							<?php endif ?>
							<br>
							<br>
							<div class="desc-p">
								<h4>Descripción</h4>
								<?php 
									if (strlen(strip_tags($producto->descripcion)) <=150) {
										echo $producto->descripcion;
								  	} else {
										echo substr(strip_tags($producto->descripcion), 0, 150) . '...';
									}
								?>
							</div>
						</div>

					</div>
					<?php endforeach ?>
					
					
				</div>
    		</div>
    	</div>
    </div>
    <!-- ======= /1.05 Pricing Area ====== -->


<?php \Core\View::render('website.footer', ['scripts' => [
    'assets/scripts/producto-website.js'
]]) ?>
		