<?php \Core\View::render('master.header', ['title' => $producto->producto->nombre]) ?>
		<div class="main" style="    padding-top: 60px !important;">
			<!-- MAIN CONTENT -->
           
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
<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/carrito-user.js'
]]) ?>
		