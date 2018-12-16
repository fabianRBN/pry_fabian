<?php \Core\View::render('website.header', ['title' => 'Productos']) ?>
<!-- ======= 2.01 Page Title Area ====== -->

    <div class="pageTitleArea animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="pageTitle">
    					<div class="h2">Servicios</div>
    					<ul class="pageIndicate">
    						<li><a href="">Innovasys</a></li>
    						<li><a href="">Servicios</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <!-- ======= /2.01 Page Title Area ====== -->

    <!-- ======= 3.01 Domain Area ====== -->
    <div class="domainSearchArea secPdng">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="sectionTitle animated">
    					<div class="h2">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</div>
    				</div>
    			</div>
    			<div class="col-md-12">
    				<ul class="domains">
						<?php $count = 0; ?>
						<?php foreach($services as $service): ?>
						<?php if($count == 0): ?>
    					<li class="availableDomain clearfix  animated">
    						<div class="aDomainLeft clearfix">
    							<div class="checkIcon"><i class="icofont icofont-verification-check"></i></div>
    							<div class="DomainName">
    								<div class="h3"><?php echo $service->nombre ?></div>
    								<span>Disponible ahora!</span>
    							</div>
    						</div>
    						<div class="domainBtn clearfix">
							<a href="#" class="btnCart Btn">$<?php echo number_format($service->precio, 2) ?></a>
    							<a href="<?php \Core\Router::url('connect?servicio=' . $service->id) ?>" class="btnBuy Btn">Cotizar</a>
    						</div>
    					</li>
						<?php else: ?>
    					<li class="singleDomain  animated">
    						<div class="h4 singleDomainName"><?php echo $service->nombre ?></div>
    						<div class="singleDomainRight">
    							<h4 class="price">$<?php echo number_format($service->precio, 2) ?></h4>
    							<a href="<?php \Core\Router::url('connect?servicio=' . $service->id) ?>" class="cartBtn">Cotizar</a>
    						</div>
    					</li>
						<?php endif ?>
						<?php $count++ ?>
						<?php endforeach ?>
    				</ul>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- ======= /3.01 Domain Area ====== -->


    <!-- ======= 3.02 Domain cta Area ====== -->
    <div class="domainCtaArea  animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="domainCta">
    					<div class="h2">Lorem ipsum dolor sit amet consectetur adipisicing elit. </div>
    					<a href="#" class="ctaBtn Btn">Lorem</a>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- ======= /3.02 Domain cta Area ====== -->

<?php \Core\View::render('website.footer') ?>
		