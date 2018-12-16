<?php \Core\View::render('master.header', ['title' => 'Productos']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			
			<div class="main-content">
			<nav aria-label="breadcrumb" >
            <ol class="breadcrumb" style="margin-bottom: 1%;"> 
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item active" aria-current="page">Productos</li>
            </ol>
            </nav>
				<div class="container-fluid">
				<?php if(count((array) \Core\Session::get('cart')) > 0 && !in_array(false, ((array) \Core\Session::get('cart')))  ): ?>
					<div class="alert alert-success" style="    background-color: #019ee1; border-color: #5bc0de00;" id="notpro">
						<a href="<?php \Core\Router::url('administracion/carrito') ?>"  style="color: white;" class="alert-link">Tienes  <?php echo count((array) \Core\Session::get('cart')); ?> productos pendientes en carrito </a>
						<button type="button" class="close"  id="btndelete">
							<span aria-hidden="true" style="color: white;">×</span>
						</button>
					</div>
				<?php else: ?>	
				<?php endif ?>
			
				
					<div class="row">
						<?php if(count($products) == 0): ?>
						<div class="col-md-4" style="height: 500px">
							<!-- PANEL DEFAULT -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">
										No tienes productos contratados
									</h3>
								</div>
								<div class="panel-footer">
									<a href="<?php echo \Core\Router::url('tienda/productosvirtual') ?>" type="button" class="btn btn-default btn-block"><i class="fa fa-edit"></i> Contratar productos </a>
								</div>
							</div>
							<!-- END PANEL DEFAULT -->
						</div>
						<?php else: ?>
						<?php foreach($products as $product): ?>
						<div class="col-md-4" >
							<!-- PANEL DEFAULT -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">
										<?php echo $product->producto->nombre ?> 
										<br> <br>
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
									<small>Estatus: &nbsp;&nbsp;<?php echo \App\Models\Estatus::calculate($product->estatus,'carrito') ?></small><br>
									<small>URL: &nbsp;&nbsp; <a href=<?php echo $product->url_aprovisionamiento ?> style="word-wrap: break-word;">
										<?php echo $product->url_aprovisionamiento ?>
									 </a> </small>
									
								</div>
								<div id="opciones" class="panel-body">
									<?php foreach($product->opciones as $key=> $opcion): if($key == 3)continue; ?>
									
                                    <div >
                                        <span><?php echo $opcion->nombre ?> </span>: 
                                        <br> 
                                        <span class="label label-default" id="<?php echo \Core\Helper::slugify($opcion->nombre) ?>">
                                        <?php echo $opcion->value ?>
                                        </span>
                                    </div>
									
									<?php endforeach ?>
								</div>
								
								<div class="panel-footer">
									<?php if($product->estatus==9):?>
									<a type="button" class="  btn-block" style="    text-align: center;"> Por cancelar </a>
									<?php else: ?>
									<a href="<?php echo \Core\Router::url('administracion/detalle?id=' . $product->id) ?>" type="button" class="btn btn-default btn-block"><i class="fa fa-edit"></i> Administrar </a>
									<?php endif ?>
								</div>
							</div>
							<!-- END PANEL DEFAULT -->
						</div>
						<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>|

<?php \Core\View::render('master.footer') ?>
		