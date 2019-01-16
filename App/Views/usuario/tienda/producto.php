<?php \Core\View::render('master.header', ['title' => $producto->nombre]) ?>
		<div class="main">
            
            <?php if(\Core\Session::has('cart_product_options_' . $producto->id)): ?>
            <span  data-json-prev='<?php echo json_encode(\Core\Session::get('cart_product_options_' . $producto->id)) ?>'></span>
            <?php endif ?>
			<!-- MAIN CONTENT -->
			<div class="main-content"  info data-cliente="<?php echo \Core\Session::get('sivoz_auth')->id ?>" data-producto="<?php echo $producto->id ?>">
				
                <nav aria-label="breadcrumb" >
                    <ol class="breadcrumb" style="margin-bottom: 1%;"> 
                    <li class="breadcrumb-item"><a href="<?php \Core\Router::url("/administracion") ?>"> Admin </a></li>
                        <li class="breadcrumb-item"><a href="<?php \Core\Router::url("/administracion/carrito") ?>"> Carrito </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Configuración de  <?php echo $producto->nombre ?></li>
                    </ol>
                </nav>
                
                <div class="container-fluid">
					<div class="row">
                        <div class="col-sm-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Precio desde: <span class="label label-info"><?php echo '$' . number_format($producto->precio, 2) ?>
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
                                            <!-- Button trigger modal -->

                                            <h4>Precio <span data-tipo-pago="<?php echo $producto->tipo_pago ?>" data-precio-global="<?php echo $producto->precio ?>" class="label label-info"><?php echo '$' . number_format($producto->precio, 2) ?>
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
                                            </h4>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Solicitar
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de solicitud</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <div class="">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">Desea confirmar la solicitud de <?php echo $producto->nombre ?></div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <h4>Caracteristicas</h4>
                                                        <?php foreach($producto->opciones as $opcion): ?>
                                                        <div>
                                                            <span><?php echo $opcion->nombre ?></span>: 
                                                            <br> 
                                                            <span class="label label-default" id="<?php echo (\Core\Helper::slugify($opcion->nombre))."2" ?>">
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
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input  type="hidden" id="tokenCSRF" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >

                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <a href="" id="add-to-cart"  class="btn btn-info">Solicitar</a>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($producto->configurable == 1){?>
                        <div class="col-sm-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Configuración de producto
                                    </div>
                                </div>
                                <div class="panel-body">
                                <form id="options-form">
                                <?php foreach($producto->opciones as $opcion): ?>
                                <?php if($opcion->tipo == 1): ?>
                                <div class="from-group" >
                                    <br>
                                    
                                    <label for=""><?php echo $opcion->nombre ?> </label>
                                    <?php if($producto->mostrar_label == 1): ?>
                                    - <div class="badge badge-info"><?php echo '$' . number_format($opcion->precio,2) ?></div>
                                    <?php endif ?>                                    <div class="range-div " style="   margin-top: 1%;">
                                    <div class="col-5" style="    width: 50%;">
                                        <input data-precio="<?php echo $opcion->precio  ?>"   data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" data-valor="<?php echo $opcion->valor  ?>"  value="<?php echo $opcion->valor  ?>"type="range" class="custom-range"  min="<?php echo $opcion->min ?>" max="<?php echo $opcion->max ?>" class="form-control range-input">
                                    </div>
                                    <div class="col-5" style="    width: 15%;">
                                        <input data-precio="<?php echo $opcion->precio  ?>"   data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" data-valor="<?php echo $opcion->valor  ?>"  value="<?php echo $opcion->valor  ?>"type="number"  min="<?php echo $opcion->min ?>" max="<?php echo $opcion->max ?>" class="form-control custom-input">
                                    </div>
                                    <div class="col-2" style="    width: 15%;">
                                    <div class="badge badge-info col-2" style="   margin-top: 1%;"><span class="range-slider__value "><?php echo $opcion->valor  ?></span></div>
                                        
                                    </div>
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 2): ?>
                                <div class="from-group">
                                    <br>
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <?php if(intval($producto->mostrar_label) > 0): ?>
                                    - <div class="badge badge-info"><?php echo '$' . number_format($opcion->precio,2) ?></div>
                                    <?php endif ?>
                                    <input data-precio="<?php echo $opcion->precio ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $opcion->valor ?>" type="text" class="form-control">
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 4): ?>
                                <div class="from-group">
                                    <br>
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <?php if(intval($producto->mostrar_label) > 0): ?>
                                    - <div class="badge badge-info"><?php echo '$' . number_format($opcion->precio,2) ?></div>
                                    <?php endif ?>
                                    <label class="fancy-checkbox">
                                        <input data-precio="<?php echo $opcion->precio ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" type="checkbox">
                                        <span><?php echo $opcion->nombre ?> 
                                            
                                        </span>
                                    </label>
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 5): ?>
                                <div class="form-group">
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <?php if(intval($producto->mostrar_label) > 0): ?>
                                    - <div class="badge badge-info"><?php echo '$' . number_format($opcion->precio,2) ?></div>
                                    <?php endif ?>
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
                                        <input checked data-precio="<?php echo $cop ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $o ?>" data-cop="<?php echo \Core\Helper::slugify($opcion->nombre) .'-'. $count ?>" type="radio">
                                        <span><i></i><?php echo $o ?> </span>
                                        <?php else: ?>
                                        <input data-precio="<?php echo $cop ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $o ?>" type="radio" data-cop="<?php echo \Core\Helper::slugify($opcion->nombre) .'-'. $count ?>">
                                        <span><i></i><?php echo $o ?> </span>
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
                        <?php }?>
					</div>
				</div>
            </div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer', ['scripts' => [
    'assets/scripts/producto.js'
]]) ?>
		