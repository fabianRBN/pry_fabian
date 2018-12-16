<?php \Core\View::render('master.header', ['title' => 'Servicios']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra un Servicio</h3>
						</div>
						<div class="panel-body no-padding">
							<form method="post" action="<?php echo \Core\Router::url('catalogos/crear-servicio') ?>" id="servicio-form" data-type="add">
								<div class="col-sm-4">
									<div class="form-group">
										<input class="form-control" data-required="true" name="nombre" servicio-name="nombre" type="text" placeholder="Nombre">
									</div>
								</div>
                                <div class="col-sm-4">
									<div class="form-group">
										<input class="form-control" data-required="true" name="precio" servicio-name="precio" id="price" type="text" placeholder="Precio del servicio">
									</div>
								</div>
								<div class="col-sm-4">
									<select data-required="true" servicio-name="forma_pago" name="forma_pago" id="forma_pago" class="form-control">
										<option value="NA">Forma de Pago</option>
										<option value="1">Pago único</option>
										<option value="2">Diario</option>
										<option value="3">Semanal</option>
										<option value="4">Quincenal</option>
										<option value="5">Mensual</option>
										<option value="6">Anual</option>
									</select>
									<br>
								</div>
                                <div class="col-sm-12">
                                    <label for="">Información de este servicio</label>
                                    <textarea servicio-name="descripcion" name="descripcion" id="editor" cols="30" rows="10"></textarea>
                                </div>
								<div class="col-sm-12">
									<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Servicios</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Precio</th>
										<th>Forma de Pago</th>
										<th>Fecha de creación</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($servicios as $servicio): ?>
									<tr>
										<td><?php echo $servicio->nombre ?></td>
										<td><?php echo "$".number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $servicio->precio)),2); ?></td>
                                        <?php if($servicio->forma_pago == 1): ?>
                                        <td>Pago único</td>
                                        <?php endif ?>
                                        <?php if($servicio->forma_pago == 2): ?>
                                        <td>Diario</td>
                                        <?php endif ?>
                                        <?php if($servicio->forma_pago == 3): ?>
                                        <td>Semanal</td>
                                        <?php endif ?>
                                        <?php if($servicio->forma_pago == 4): ?>
                                        <td>Quincenal</td>
                                        <?php endif ?>
                                        <?php if($servicio->forma_pago == 5): ?>
                                        <td>Mensual</td>
                                        <?php endif ?>
                                        <?php if($servicio->forma_pago == 6): ?>
                                        <td>Anual</td>
                                        <?php endif ?>
										<td><?php echo date( "d/m/Y", strtotime($servicio->fecha)) ?></td>
										<td><a data-id="<?php echo $servicio->id ?>" class="btn btn-primary servicios">Editar</a>&nbsp;<a href="<?php \Core\Router::url('catalogos/flujo?id=' . $servicio->id . '&tipo=servicio') ?>" class="btn btn-success productos">Flujo de Estatus</a></td>
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
<?php \Core\View::render('master.footer',['scripts' => [
	'assets/scripts/servicios.js'
]]) ?>
		