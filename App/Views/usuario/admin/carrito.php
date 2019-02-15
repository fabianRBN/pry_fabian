<?php \Core\View::render('master.header', ['title' => $producto->producto->nombre]) ?>
		<div class="main" style="    padding-top: 60px !important;">
			<!-- MAIN CONTENT -->
            <input id="idCarrito"  type="hidden" name="idCarrito" value="<?php echo $producto->id ?>" >
            <input id="idproducto"  type="hidden" name="idproducto" value="<?php echo $producto->producto->id ?>" >

            <input id="idestatus"  type="hidden" name="idestatus" value="<?php echo $producto->estatus ?>" >
			<div class="main-content">

			<nav aria-label="breadcrumb" >
                <ol class="breadcrumb" style="margin-bottom: 1%;"> 
                <li class="breadcrumb-item"><a href="<?php \Core\Router::url("/administracion") ?>"> Admin </a> </li>
                <li class="breadcrumb-item"><a href="<?php \Core\Router::url("/administracion/productos") ?>"> Productos </a> </li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle de <?php echo $producto->producto->nombre ?></li>
                </ol>
            </nav>

            <div class="row page-titles">
                    
                </div>
				<div class="container-fluid">
					<div class="row">
                        <div class="col-sm-6">
                           
                            <?php foreach($alerts as $alert): ?>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"><?php echo $alert->titulo ?></div>
                                </div>
                                <div class="panel-body">
                                    <?php if($alert->id_usuario == 0): ?>
                                    <?php endif ?>
                                    <b><?php echo ($alert->id_usuario == 0 ? 'Cliente' :  'Usuario') ?> notificado: </b> <?php echo ($alert->id_usuario == 0 ? $alert->cliente :  $alert->usuario) ?> <br>
                                    <b>Usuario gestor: </b> <?php echo ($alert->asesor == 0 ? 'SISTEMA' :  $alert->gestor) ?> <br>
                                    <b>Fecha: </b> <?php echo date('Y-m-d',strtotime($alert->fecha_creacion)) ?> <br>
                                    <b>Comentario:</b> <br>
                                    <?php echo $alert->comentario ?>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Precio <span class="label label-info"><?php echo '$' . number_format($producto->total, 2) ?>
                                        <?php if($producto->producto->tipo_pago == 0): ?>
										/dia
										<?php elseif($producto->producto->tipo_pago == 1): ?>
										/semana
										<?php elseif($producto->producto->tipo_pago == 2): ?>
										/quincena
										<?php elseif($producto->producto->tipo_pago == 3): ?>
										/mes
										<?php elseif($producto->producto->tipo_pago == 4): ?>
										/año
										<?php endif ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $producto->producto->descripcion ?>
                                </div>
                                <div class="panel-footer">
                                    <b>Estatus de la compra</b>: <br><?php echo \App\Models\Estatus::calculate($producto->estatus,'carrito') ?> <br><br>
                                    <b>Nombre de Cliente</b>:  <br><?php echo $producto->cliente->nombre . ' ' .$producto->cliente->apellidos ?> <br><br>
                                    <b>Fecha de aprovisionamiento</b>: <br> 
                                    <?php if($producto->fecha_aprovisionamiento !== '0000-00-00 00:00:00'): ?>
                                    <?php echo $producto->fecha_aprovisionamiento ?>
                                    <?php else: ?>
                                    No proporcionada
                                    <?php endif ?>
                                </div>
                                <div class="panel-footer">
                                    <div style=" display: flex; justify-content: space-between;" >
                                        <h5><?php echo $producto->producto->nombre ?></h5>
                                        <?php echo "<script>console.log(".json_encode($producto).")</script>" ?>
                                        <?php if($producto->estatus == 0 || $producto->estatus == 13 || $producto->estatus == 1 ||$producto->estatus == 2  ):?>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                                    Editar
                                            </button>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">Configuración de producto</div>
                                </div>
                                <div class="panel-body">
                                    <?php foreach($producto->opciones as $opcion): ?>
                                    <div>
                                        <span><?php echo $opcion->nombre ?></span>: 
                                        <br> 
                                        <span class="label label-default" id="<?php echo \Core\Helper::slugify($opcion->nombre) ?>">
                                        <?php echo $opcion->value ?>
                                        </span>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <?php if($producto->estatus == 6 || $producto->estatus == 3): ?>
                                <?php else: ?>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button data-toggle="modal" data-target="#myModal" class="btn btn-danger">Cancelar solicitud de producto</button>
                                        </div>
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
					</div>
				</div>
            </div>
			<!-- END MAIN CONTENT -->
		</div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cancelar compra de producto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea name="cancelar" placeholder="Describe por que se cancela esta petición" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input  type="hidden" id="tokenCSRF" name="tokenCSRF" value="<?php echo strval(\Core\Session::createToken() )?>" >
                <button type="button" id="cancel-cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="enviar-cancelar" class="btn btn-info">Enviar</button>
            </div>
            </div>
        </div>
        </div>
        <div carrito data-id="<?php echo $producto->id ?>"></div>


       <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            <div class="modal-header" style="display: flex;">
                <h5 class="modal-title" id="exampleModalLongTitle" style=" width: 90%;">Editar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 10%;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="height: 500px;" >
                <div class="col-sm-12" style=" display: flex; justify-content: space-around;" > 
                    <div class="panel col-sm-5 ">
                        <div class="panel-heading">
                            <div class="panel-title">Configuración actual</div>
                        </div>
                        <div class="panel-body">
                            <?php foreach($producto->opciones as $opcion): ?>
                            <div style=" margin-bottom: 2%;" >
                                <span><?php echo $opcion->nombre." " ?></span>: 
                                <br> 
                                <span  class="label label-default" id="<?php echo \Core\Helper::slugify($opcion->nombre) ?>">
                                <?php echo $opcion->value ?>
                                </span>
                            </div>
                            <?php endforeach ?>
                        <br><br>
                        <div >
                        
                            Precio actual:<span class="label label-info"><?php echo '$' . number_format($producto->total, 2) ?>
                            <?php if($producto->producto->tipo_pago == 0): ?>
                            /dia
                            <?php elseif($producto->producto->tipo_pago == 1): ?>
                            /semana
                            <?php elseif($producto->producto->tipo_pago == 2): ?>
                            /quincena
                            <?php elseif($producto->producto->tipo_pago == 3): ?>
                            /mes
                            <?php elseif($producto->producto->tipo_pago == 4): ?>
                            /año
                            <?php endif ?>
                            </span>
                        </div>
                    
                        </div>
                        
                    
                    </div>
                    <div class="panel col-sm-6">
                        <div class="panel-heading">
                            <div class="panel-title">Nueva configuracion</div>
                        </div>
                        <div class="panel-body">
                        <?php if($product->configurable == 1){?>
                        <div class="col-sm-12">
                        
                                <form id="options-form">
                                <?php foreach($product->opciones as $opcion): ?>
                                <?php if($opcion->tipo == 1): ?>
                                <div class="from-group" >
                                    <br>
                                    
                                    <label for=""><?php echo $opcion->nombre ?> </label>
                                    <?php if($product->mostrar_label == 1): ?>
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
                                    <?php if(intval($product->mostrar_label) > 0): ?>
                                    - <div class="badge badge-info"><?php echo '$' . number_format($opcion->precio,2) ?></div>
                                    <?php endif ?>
                                    <input data-precio="<?php echo $opcion->precio ?>" data-type="<?php echo $opcion->tipo ?>" data-id="<?php echo $opcion->id ?>" data-change="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" name="<?php echo \Core\Helper::slugify($opcion->nombre) ?>" value="<?php echo $opcion->valor ?>" type="text" class="form-control">
                                </div>
                                <?php endif ?>
                                <?php if($opcion->tipo == 4): ?>
                                <div class="from-group">
                                    <br>
                                    <label for=""><?php echo $opcion->nombre ?></label>
                                    <?php if(intval($product->mostrar_label) > 0): ?>
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
                                    <?php if(intval($product->mostrar_label) > 0): ?>
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
                        <?php }?>
                        </div>
                    
                   
                </div>
                
            </div>
            <div class="modal-footer" style="display: flex;  justify-content: space-between;">
                <div style="display: flex;     justify-content: space-between; width: 100%;"> 
                
                <div>
                   <h4>
                        Nuevo precio: <span data-tipo-pago="<?php echo $product->tipo_pago ?>" data-precio-global="<?php echo $product->precio ?>" class="label label-info"><?php echo '$' . number_format($product->precio, 2) ?>
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

                    </h4>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="edit-to-cart" type="button" class="btn btn-primary">Guardar Cambios</button>
                </div>

                </div>

                
            </div>
            </div>
        </div>
        </div>

<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/carrito-user.js','assets/scripts/producto.js'
]]) ?>
		