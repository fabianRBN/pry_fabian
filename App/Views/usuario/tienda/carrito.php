<?php \Core\View::render('master.header', ['title' => 'Carrito']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			
			<div class="main-content">
			<nav aria-label="breadcrumb" >
            <ol class="breadcrumb" style="margin-bottom: 1%;"> 
                <li class="breadcrumb-item"><a href="<?php \Core\Router::url("/administracion") ?>"> Admin </a></li>
                <li class="breadcrumb-item active" aria-current="page">Carrito</li>
                
            </ol>
            </nav>
				<div class="container-fluid">
					<div class="row">
						<?php foreach($productos as $producto): ?>
						<div class="col-md-4">
							<!-- PANEL DEFAULT -->
							<div class="panel">

								<div class="panel-heading">

									<h3 class="panel-title">
									<div style="    display: flex;flex-direction: row; flex-wrap: nowrap; justify-content: space-between; align-items: stretch; align-content: stretch;">
										<div style="flex-grow: 0; flex-shrink: 1; flex-basis: auto;">
										<?php echo $producto->nombre ?> 
										</div>
										<div style="flex-grow: 0; flex-shrink: 1; flex-basis: auto;">
										<a href="<?php \Core\Router::url('remove-to-cart-admin?producto=' . $producto->id) ?>"><span  class="closeIcon">x</span></a>

										</div>
									</div>

										<br><br>
										<span class="label label-info">
										
										<?php echo '$' . number_format($producto->precio, 2) ?>
										<?php if($producto->tipo_pago == 0): ?>
										/dia
										<?php elseif($producto->tipo_pago == 1): ?>
										/semana
										<?php elseif($producto->tipo_pago == 2): ?>
										/quincena
										<?php elseif($producto->tipo_pago == 3): ?>
										/mes
										<?php elseif($producto->tipo_pago == 4): ?>
										/año
										<?php endif ?>
										</span>
									</h3>
								</div>
								<div class="panel-body">
									<!--llamamos la clase expandable adicional podemos darle mas estilo pero ese no es el foco del tutorial-->
									<div class="expandable">
									<!-- Nuestro parrafo a mostrar-->
										<p><?php echo $producto->descripcion ?></p>
									</div>
									
								</div>
								<div class="panel-footer">
									<a href="#" onclick= <?php echo "productos(".$producto->id ."); return false;" ?> type="button" class="btn btn-default btn-block"><i class="fa fa-edit"></i> Solicitar </a>
								</div>
							</div>
							<!-- END PANEL DEFAULT -->
						</div>
						<?php endforeach ?>
					</div>
				</div>
				<input id="tokenCSRF"  type="hidden" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		