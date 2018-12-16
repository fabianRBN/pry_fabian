<?php \Core\View::render('master.header', ['title' => 'Servicios']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Categorización</h3>
						</div>
                        <?php if($cat !== false): ?>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/categoria-save') ?>">
								<div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="hidden" name="id" value="<?php echo $cat->id ?>">
                                        <input type="hidden" name="action" value="edit">
										<input class="form-control" value="<?php echo $cat->nombre ?>" name="nombre"  type="text" placeholder="">
									</div>
								</div>
								<div class="col-sm-12">
									<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
							</form>
						</div>
                        <?php else: ?>
                        <div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/categoria-save') ?>">
								<div class="col-sm-12">
									<div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="hidden" name="action" value="new">
										<input class="form-control" name="nombre"  type="text" placeholder="">
									</div>
								</div>
								<div class="col-sm-12">
									<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
							</form>
						</div>
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
										<th>Productos</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($categorias as $categoria): ?>
									<tr>
										<td><?php echo $categoria->nombre ?></td>
										<td><?php echo $categoria->productos ?></td>
										<td><a href="<?php echo \Core\Router::url('catalogos/categoria?id=' . $categoria->id) ?>" class="btn btn-primary servicios">Editar</a>
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
		