<?php \Core\View::render('master.header', ['title' => 'Servicios']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Modificación de nombres de estatus</h3>
						</div>
                        <?php if($es !== false): ?>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/estatus-save') ?>">
								<div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="hidden" name="id" value="<?php echo $es->id ?>">
                                        <input type="hidden" name="action" value="edit">
										<input class="form-control" value="<?php echo $es->nombre ?>" name="nombre"  type="text" placeholder="">
									</div>
								</div>
                                <div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Título</label>
										<input class="form-control" value="<?php echo $es->titulo ?>" name="titulo"  type="text" placeholder="">
									</div>
								</div>
                                <div class="col-sm-12">
                                    <label for="">Mensaje</label>
                                    <textarea name="mensaje" class="form-control" cols="30" rows="10"><?php echo $es->titulo ?></textarea>
                                </div>
								<div class="col-sm-12">
									<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
							</form>
						</div>
                        <?php else: ?>
                        <!--<div class="panel-body no-padding">
							<form method="post" action="<?php //echo \Core\Router::url('catalogos/estatus-save') ?>">
								<div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="hidden" name="action" value="new">
										<input class="form-control" name="nombre"  type="text" placeholder="">
									</div>
								</div>
                                <div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Título</label>
										<input class="form-control" name="titulo"  type="text" placeholder="">
									</div>
								</div>
                                <div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Tipo</label>
										<input class="form-control" name="tipo"  type="text" placeholder="">
									</div>
								</div>
                                <div class="col-sm-12">
                                    <label for="">Comentario</label>
                                    <textarea name="comentario" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Mensaje</label>
                                    <textarea name="mensaje" class="form-control" cols="30" rows="10"></textarea>
                                </div>
								<div class="col-sm-12">
									<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
							</form>
						</div>-->
                        <?php endif ?>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Estatus</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Tipo</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($estatus as $e): ?>
									<tr>
										<td><?php echo $e->nombre ?></td>
										<td><?php echo $e->tipo ?></td>
										<td><a href="<?php echo \Core\Router::url('catalogos/estatus?id=' . $e->id) ?>" class="btn btn-primary servicios">Editar</a>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<div id="url" data-url='<?php echo \App\Config::Domain ?>'></div>
<?php \Core\View::render('master.footer') ?>
		