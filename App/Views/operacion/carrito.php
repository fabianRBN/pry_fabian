<?php \Core\View::render('master.header', ['title' => $producto->producto->nombre]) ?>
		<div class="main">
			<!-- MAIN CONTENT -->

            

 
            <input type="hidden" value = '<?php echo json_encode($asignacion)?>'  id= "asignacion">
            <input type="hidden" value = '<?php echo $producto->estatus_data->codigo?>'  id= "idestatus">
            <input type="hidden" value = '<?php echo \Core\Session::get('sivoz_auth')->id?>'  id= "idUsuario">

            <?PHP echo "<script> console.log(".json_encode($producto).")</script>" ?>
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
                            

                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">Cargar Archivos de estado </div>
                                </div>
                                <div class="panel-body">
                                    <form id="uploadImage" action='<?php echo \App\Config::Domain .'operacion/fileupload'  ?>'  method="post">

                                        <div class="form-group">
                                            
                                                <input type="text" name="textalias" placeholder="Nombre del archivo" value="<?php echo  $producto->id."_". $producto->cliente->nombre."_". $producto->estatus_data->nombre."_".  $producto->producto->nombre?>" class="custom-file-input form-control" >
                                                <input type="hidden" name="txtidcarrito" id="id_carrito" value="<?php echo $producto->id?>" >
                                                <input type="hidden" name="txtidUsuario"  value='<?php echo  \Core\Session::get('sivoz_auth')->id ?>' >
                                                <input type="hidden" name="txtestatus"  value="<?php echo $producto->estatus?>">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">     
                                                <div class="col-sm-9"> 

                                                    <div class="custom-file">
                                                        <input type="file" name="uploadFile" id="uploadFile"  class="form-control" accept="application/pdf" lang="es">
                                                    </div>
                                                </div>
                                                <div id="targetLayer" style="display:none;"></div>
                                                <div class="col-sm-3">
                                                    <button type="submit" id="uploadSubmit"  class="btn btn-success">Cargar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <h5>Archivos</h5>

                                    <div class="row">
                                        <?php foreach( $archivos as $archivo): ?>
                                            <div class="col-sm-8">
                                                <b><?php  echo $archivo->estatus ?></b>: <br> <a target="_blank" href=" <?php  echo \App\Config::Domain."reportes/reporte?archivo=". $archivo->nombre ?>"><?php echo $archivo->nombre ?></a><br><br>                                           
                                            </div>
                                            
                                        <?php endforeach ?>
                                        
                                    </div>
                                </div>
                            </div>
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

                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">Historial de estatus</div>
                                </div>
                                <div class="panel-body">
                                <ul class="list-group">
                                    <?php foreach($asignacion as $asignado): ?>
                                        <li class="list-group-item"> <?php echo  $asignado->estado.":  <span class='label label-default' style='    font-size: 13px;'>".$asignado->usuario."</span>" ?></li>
                                    <?php endforeach ?>
                                </ul>
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
										
									</select>
                            </div>
                            <div class="form-group">
                                <textarea name="regresion" placeholder="Comentario" id="" cols="30" rows="10" class="form-control">Se ha aprovisionado tu petición</textarea>
                            </div>

                           
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;  justify-content: space-between;">
                    <div style="display: flex;     justify-content: space-between; width: 100%;">
                        <div style="    margin-top: 10px; margin-left: 5px;">
                            <span  id="usericon" class="lnr lnr-user" title="Notificación a usuarios"></span>
                            
                            <span style = "margin-left: 5px;" id="clienticon"  title="Notificación a clientes" class="lnr lnr-bubble"></span>
                        </div>
                        <div>
                            <button type="button" id="cancel-regresion" class="btn btn-default" data-dismiss="modal">cancelar</button>
                            <button type="button" id="enviar-regresion" class="btn btn-success">Enviar</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>
        <div carrito data-id="<?php echo $producto->id ?>">
       
        
        </div>
        <div carrito-total data-total="<?php echo number_format($producto->total, 2) ?>">
        </div>
        <div id="url" data-url='<?php echo \App\Config::Domain ?>'></div>
<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/carrito.js','assets/scripts/jquery.form.js'
]]) ?>
		