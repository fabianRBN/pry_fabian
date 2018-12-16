<?php \Core\View::render('master.header', ['title' => $producto->producto->nombre]) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
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
                                        Precio <span class="label label-success"><?php echo '$' . number_format($producto->producto->precio, 2) ?>
                                        <?php if($producto->producto->forma_pago == 0): ?>
										/dia
										<?php elseif($producto->producto->forma_pago == 1): ?>
										/semana
										<?php elseif($producto->producto->forma_pago == 2): ?>
										/quincena
										<?php elseif($producto->producto->forma_pago == 3): ?>
										/mes
										<?php elseif($producto->producto->forma_pago == 4): ?>
										/año
										<?php endif ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $producto->producto->descripcion ?>
                                </div>
                                <div class="panel-footer">
                                    <b>Estatus de la suscripcion</b>: <br><?php echo \App\Models\Estatus::calculate($producto->estatus,'servicio') ?> <br><br>
                                    <b>Nombre de Cliente</b>:  <br><?php echo $producto->cliente->nombre . ' ' .$producto->cliente->apellidos ?> <br><br>
                                </div>
                                <div class="panel-footer">
                                    <h5><?php echo $producto->producto->nombre ?></h5>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">Configuración de producto</div>
                                </div>
                                <?php if($producto->estatus == 2): ?>
                                <?php else: ?>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button data-toggle="modal" data-target="#myModal" class="btn btn-danger">Cancelar suscripcion</button>
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
                <h4 class="modal-title" id="myModalLabel">Rechazar petición</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea name="rechazado" placeholder="Describe por que se rechaza esta petición" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel-rechazado" class="btn btn-default" data-dismiss="modal">cancelar</button>
                <button type="button" id="enviar-rechazado" class="btn btn-success">Enviar</button>
            </div>
            </div>
        </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="regresar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Regresar petición</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="regresion" placeholder="Describe por que se regresa esta petición" id="" cols="30" rows="10" class="form-control"></textarea>
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
        <!-- Modal -->
        <div class="modal fade" id="aprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Aprobar petición</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="date" name="fecha_aprovisionamiento" placeholder="Fecha de aprovisionamiento" class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea name="aprobar" placeholder="Comentario" id="" cols="30" rows="10" class="form-control">Se ha aprobado tu solicitud</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-aprobar" class="btn btn-default" data-dismiss="modal">cancelar</button>
                    <button type="button" id="enviar-aprobar" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade" id="aprovisionar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <textarea name="aprovisionar" placeholder="Comentario" id="" cols="30" rows="10" class="form-control">Se ha aprovisionado tu petición</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-aprovisionar" class="btn btn-default" data-dismiss="modal">cancelar</button>
                    <button type="button" id="enviar-aprovisionar" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade" id="suspender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Suspender petición</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="suspender" placeholder="Comentario" id="" cols="30" rows="10" class="form-control">Se ha suspendido tu petición</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-suspender" class="btn btn-default" data-dismiss="modal">cancelar</button>
                    <button type="button" id="enviar-suspender" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade" id="reactivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reactivar petición</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="reactivar" placeholder="Comentario" id="" cols="30" rows="10" class="form-control">Se ha reactivado tu petición</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-reactivar" class="btn btn-default" data-dismiss="modal">cancelar</button>
                    <button type="button" id="enviar-reactivar" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
        </div>
        <div carrito data-id="<?php echo $producto->id ?>"></div>
<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/carrito.js'
]]) ?>
		