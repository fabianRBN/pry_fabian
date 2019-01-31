<?php \Core\View::render('master.header', ['title' => 'Notificaciones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
                        <div class="col-sm-12">
                        
                            
                            <?php foreach($alerts as $alert): ?>
                            <?php echo "<script>console.log(".json_encode($alert).")</script>" ?>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"><a href="<?php \Core\Router::url($alert->url) ?>"><?php echo $alert->titulo ?></a></div>
                                </div>
                                <div class="panel-body">
                                    <?php if($alert->id_usuario == 0): ?>
                                    <?php endif ?>
                                    <b>Usuario gestor: </b> <?php echo ($alert->asesor == 0 ? 'SISTEMA' :  $alert->gestor) ?> <br>
                                    <b>Fecha: </b> <?php echo date('Y-m-d h:i:s',strtotime($alert->fecha_creacion)) ?> <br>
                                    <b>Comentario:</b> <br>
                                    <?php echo $alert->comentario ?>
                                    
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
					</div>
				</div>
            </div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		