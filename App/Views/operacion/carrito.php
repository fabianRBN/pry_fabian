<?php \Core\View::render('master.header', ['title' => $producto->producto->nombre]) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
                        <?php if($producto->estatus == 15): ?>
                        <?php else: ?>
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">Cambiar el estatus del producto</div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row" data-json='<?php echo json_encode($producto->consecutivos) ?>'>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <select name="estatus" id="estatus" class="form-control">
                                                    <?php foreach($producto->consecutivos as $consecutivo): ?>
                                                    <option value="<?php echo $consecutivo->codigo ?>"><?php echo $consecutivo->titulo ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            
                                            <div class="form-group">
                                                <button data-toggle="modal" data-target="#myModal" class="btn btn-info open-modal">Cambiar estatus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
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
                                    <b>Fecha: </b> <?php echo date('Y-m-d h:i:s',strtotime($alert->fecha_creacion)) ?> <br>
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
                                    <?php if($producto->precio_aprovisionamiento != null && $producto->precio_aprovisionamiento != 0): ?>
                                    <br>
                                    <div class="panel-title">
                                        Precio final <span class="label label-info"><?php echo '$' . number_format($producto->precio_aprovisionamiento, 2) ?>
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
                                    <?php endif ?>
                                </div>
                                <div class="panel-body">
                                    <?php echo $producto->producto->descripcion ?>
                                </div>
                                <div class="panel-footer">
                                    <b>Estatus de la compra</b>: <br><?php echo $producto->estatus_data->nombre ?> <br><br>
                                    <b>Nombre de Cliente</b>:  <br><?php echo $producto->cliente->nombre . ' ' .$producto->cliente->apellidos ?> <br><br>
                                    <b>Fecha de aprovisionamiento</b>: <br> 
                                    <?php if($producto->fecha_aprovisionamiento !== '0000-00-00 00:00:00'): ?>
                                    <?php echo $producto->fecha_aprovisionamiento ?>
                                    <?php else: ?>
                                    No proporcionada
                                    <?php endif ?>
                                </div>
                                <div class="panel-footer">
                                    <h5><?php echo $producto->producto->nombre ?></h5>
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
                    <h4 class="modal-title" id="myModalLabel">Aprovisionar petición</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="date" style="display: none" disabled name="fecha_aprovisionamiento" class="form-control">
                            </div>
                            <div class="form-group row" id="divprecio">
                                <label for="inputPassword" style="padding-top: 5px;     text-align: center;" class="col-sm-3 col-form-label">Precio final</label>
                                <div class="input-group col-sm-9" style="    padding-right: 15px;">
                                    

                                         <input type="number"  style="display: none" disabled name="precio_aprovisionamiento" class="form-control ">
										<span class="input-group-addon" id="precio_aprovisionamiento_span" >$</span>

								</div>
                            </div>
                            <div class="form-group">
                                    <select data-required="true" notificacion-name="usuario_notificado" name="usuario_notificado" id="usuario_notificado" class="form-control">
										<option value="NA">Notificar a un usuario</option>
                                        <?php foreach($usuarios as $usuario): ?>
                                        <?php  if($usuario->notificacion == '1'):?>
										    <option value="<?php echo $usuario->id ?>"><?php echo $usuario->nombre ?></option>
                                       
                                        <?php endif; ?>
										<?php endforeach ?>
									</select>
                            </div>
                            <div class="form-group">
                                <textarea name="regresion" placeholder="Comentario" id="" cols="30" rows="10" class="form-control">Se ha aprovisionado tu petición</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-regresion" class="btn btn-default" data-dismiss="modal">cancelar</button>
                    <button type="button" id="enviar-regresion" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
        </div>
        <div carrito data-id="<?php echo $producto->id ?>">
       
        
        </div>
        <div carrito-total data-total="<?php echo number_format($producto->total, 2) ?>">
        </div>
<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/carrito.js'
]]) ?>
		