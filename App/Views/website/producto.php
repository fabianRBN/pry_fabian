<?php \Core\View::render('website.header', ['title' =>  $producto->nombre]) ?>

    <!-- ======= 2.01 Page Title Area ====== -->

    <div class="pageTitleArea animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="pageTitle">
    					<div class="h2"><?php echo $producto->nombre ?></div>
    					<ul class="pageIndicate">
    						<li><a href="">Producto</a></li>
    						<li><a href="">Innovasys</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="container">
        <div class="row">
        <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content" info data-producto="<?php echo $producto->id ?>">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <br>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Precio <span class="label label-success"><?php echo '$' . number_format($producto->precio, 2) ?>
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
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php echo $producto->descripcion ?>
                            </div>
                            <div class="panel-footer">
                                <h5><?php echo $producto->nombre ?></h5>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Vista previa</div>
                            </div>
                            <div class="panel-body">
                                <?php foreach($producto->opciones as $opcion): ?>
                                <div>
                                    <span><?php echo $opcion->nombre ?></span>: 
                                    <br> 
                                    <span class="label label-default" id="<?php echo \Core\Helper::slugify($opcion->nombre) ?>">
                                    <?php if($opcion->tipo == 4): ?>
                                    No
                                    <?php elseif($opcion->tipo == 5): ?>
                                    <?php echo explode(',',$opcion->opciones)[0] ?>
                                    <?php else: ?>
                                    <?php echo $opcion->valor ?>
                                    <?php endif ?>
                                    </span>
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        Precio <span data-tipo-pago="<?php echo $producto->tipo_pago ?>" data-precio-global="<?php echo $producto->precio ?>" class="label label-info"><?php echo '$' . number_format($producto->precio, 2) ?>
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
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="" id="add-to-cart" class="btn btn-success">Añadir al carrito</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Configuración de producto <?php echo $producto->configurable ?>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="options-form">
                                <?php foreach($producto->opciones as $opcion): ?>
                                <?php if($opcion->tipo == 1): ?>
                                <div class="from-group">
                                    <br>
                                    <label for=""><?php echo $opcion->nombre ?> - <div class="badge badge-success"><?php echo '$' . number_format($opcion->precio,2) ?></div></label>
                                    <input <?php echo ($producto->configurable == 0 ? 'disabled' : '') ?> data-precio="<?php echo $opcion->precio ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $opcion->valor ?>" type="number" min="<?php echo $opcion->min ?>" max="<?php echo $opcion->max ?>" class="form-control">
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 2): ?>
                                <div class="from-group">
                                    <br>
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <input <?php echo ($producto->configurable == 0 ? 'disabled' : '') ?> data-precio="<?php echo $opcion->precio ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $opcion->valor ?>" type="text" class="form-control">
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 4): ?>
                                <div class="from-group">
                                    <br>
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <label class="fancy-checkbox">
                                        <input <?php echo ($producto->configurable == 0 ? 'disabled' : '') ?> data-precio="<?php echo $opcion->precio ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" type="checkbox">
                                        <span><?php echo $opcion->nombre ?> - <div class="badge badge-success"><?php echo '$' .number_format($opcion->precio,2) ?></div></span>
                                    </label>
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 5): ?>
                                <div class="form-group">
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <?php $count = 0; ?>
                                    <?php if($opcion->opciones_precio !== ''){ $ops = explode(',',$opcion->opciones_precio); }else{ $ops = [];} ?>
                                    <?php foreach(explode(',',$opcion->opciones) as $o): ?>
                                    <label class="fancy-radio">
                                        <?php
                                            if(isset($ops[$count])){
                                                $cop = $ops[$count];
                                            }else{
                                                $cop = 0;
                                            }
                                        ?>
                                        <?php if($count == 0): ?>
                                        <input <?php echo ($producto->configurable == 0 ? 'disabled' : '') ?> checked data-precio="<?php echo $cop ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $o ?>" data-cop="<?php echo \Core\Helper::slugify($opcion->nombre) .'-'. $count ?>" type="radio">
                                        <span><i></i><?php echo $o ?> - <div class="badge badge-primary"><?php echo '$' . $cop ?></div></span>
                                        <?php else: ?>
                                        <input <?php echo ($producto->configurable == 0 ? 'disabled' : '') ?> data-precio="<?php echo $cop ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $o ?>" type="radio" data-cop="<?php echo \Core\Helper::slugify($opcion->nombre) .'-'. $count ?>">
                                        <span><i></i><?php echo $o ?> - <div class="badge badge-primary"><?php echo '$' . $cop ?></div></span>
                                        <?php endif ?>
                                    </label>
                                    <?php $count++; ?>
                                    <?php endforeach ?>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
        </div>
    </div>
<?php \Core\View::render('website.footer', ['scripts' => [
    'assets/scripts/producto-website.js'
]]) ?>
		