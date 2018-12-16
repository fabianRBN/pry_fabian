<?php \Core\View::render('website.header', ['title' => 'Productos']) ?>

    <!-- ======= 2.01 Page Title Area ====== -->

    <div class="pageTitleArea animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="pageTitle">
    					<div class="h2">Productos</div>
    					<ul class="pageIndicate">
    						<li><a href="">Productos</a></li>
    						<li><a href="">Innovasys</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <!-- ======= /2.01 Page Title Area ====== -->


    <!-- ======= 4.01 Step Area ====== -->

    <div class="stepArea secPdng animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="sectionTitle">
    					<div class="h2">Lorem ipsum dolor sit, <br> amet <span>consectetur</span> adipisicing elit.</div>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-12 col-sm-4">
    				<div class="singleStep">
    					<div class="stepNo">1</div>
    					<div class="stepContent">
    						<div class="h4">Lorem</div>
    						<p>Lorem ipsum dolor sit amet, consec <br>tetuer adipiscing elit, sed diam nonum.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-xs-12 col-sm-4">
    				<div class="singleStep">
    					<div class="stepNo">2</div>
    					<div class="stepContent">
    						<div class="h4">Lorem</div>
    						<p>Lorem ipsum dolor sit amet, consec <br>tetuer adipiscing elit, sed diam nonum.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-xs-12 col-sm-4">
    				<div class="singleStep">
    					<div class="stepNo">3</div>
    					<div class="stepContent">
    						<div class="h4">Lorem</div>
    						<p>Lorem ipsum dolor sit amet, consec <br>tetuer adipiscing elit, sed diam nonum.</p>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <!-- ======= /4.01 Step Area ====== -->

    <!-- ======= 1.05 Pricing Area ====== -->
    <div class="pricingArea animated">
    	<div class="container">
    		<div class="row">
				<div class="price clearfix">
					<?php foreach($productos as $producto): ?>
					<div class="col-md-3 priceCol col-sm-5">
						<div class="singlePrice">
							<div class="priceHead">
								<span class="priceTitle"><?php echo $producto->nombre ?></span>
								<div class="priceImg">
									<img src="<?php \Core\Router::assets('website/img/icon/menu-img.png') ?>" alt="">
								</div>
								<div class="currency">$<?php echo number_format($producto->precio,2) ?><span>/
								<?php if($producto->tipo_pago == 0): ?>
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
								<li>&nbsp;</li>
								<?php else: ?>
								<li><i class="icofont icofont-ui-check"></i><?php echo $opcion->display ?></li>
								<?php endif ?>
								<?php endif ?>
								<?php else: ?>
								<li>&nbsp;</li>
								<?php endif ?>
								<?php endforeach ?>
							</ul>
							<?php if(\Core\Session::has('sivoz_auth')): ?>
							<a href="<?php \Core\Router::url('tienda/producto?id=' . $producto->id) ?>" class="priceBtn Btn">Cotizar</a>
							<?php else: ?>
							<a href="<?php \Core\Router::url('add-to-cart?producto=' . $producto->id) ?>" class="priceBtn Btn">Cotizar</a>
							<?php endif ?>
						</div>
					</div>
					<?php endforeach ?>
					
					
				</div>
    		</div>
    	</div>
    </div>
    <!-- ======= /1.05 Pricing Area ====== -->

    <!-- ======= 4.02 Faq Area ====== -->

    <div class="faqArea secPdng">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="sectionTitle">
    					<div class="h2">Lorem ipsum dolor sit, <br> amet <span>consectetur</span> adipisicing elit.</div>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-12">
    				<div class="singleFaq animated">
    					<div class="faqTitle">Duis autem vel eum iriure dolor in hendrerit in vulputate?</div>
    					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea com odo consequat.</p>
    				</div>
    				<div class="singleFaq animated">
    					<div class="faqTitle">Duis autem vel eum iriure dolor in hendrerit in vulputate?</div>
    					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
    				</div>
    				<div class="singleFaq animated">
    					<div class="faqTitle">Duis autem vel eum iriure dolor in hendrerit in vulputate?</div>
    					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea com odo consequat.</p>
    				</div>
    				<div class="singleFaq animated">
    					<div class="faqTitle">Duis autem vel eum iriure dolor in hendrerit in vulputate?</div>
    					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
    				</div>
    			</div>
    			<div class="col-md-6">
    			</div>
    		</div>
    	</div>
    </div>

    <!-- ======= /4.02 Faq Area ====== -->


    <!-- ======= 3.02 Domain cta Area ====== -->
    <div class="domainCtaArea">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="domainCta animated">
    					<div class="h2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
    					<a href="#" class="ctaBtn Btn">Regístrate ahora!</a>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- ======= /3.02 Domain cta Area ====== -->

<?php \Core\View::render('website.footer') ?>
		