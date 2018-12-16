<?php \Core\View::render('master.header', ['title' => 'Gestiones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Filtro de Reporte</h3>
					</div>
					<div class="panel-body">
						<form action="">
							<div class="col-sm-3">
								<label for="">Codigo de gestión</label>
								<select name="codigo" class="form-control">
									<option value="todos">Todos</option>
									<?php foreach($codigos as $codigo): ?>
									<option value="<?php echo $codigo->nombre ?>"><?php echo $codigo->nombre ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="">Fecha inicio</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input name="fecha_inicio" value="<?php echo date('Y-m-d') ?>" class="form-control" placeholder="Fecha inicio" type="date">
								</div>
							</div>
							<div class="col-sm-3">
								<label for="">Fecha fin</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input name="fecha_fin" value="<?php echo date('Y-m-d') ?>" class="form-control" placeholder="Fecha fin" type="date">
								</div>
							</div>
							<div class="col-sm-3">
								<br>
								<button name="tipo" value="generacion" class="btn btn-primary">Generar</button>
								<button  name="tipo" value="exportacion" class="btn btn-primary">Exportar</button>
							</div>
						</form>
					</div>
				</div>
				</div>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Gestiones</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Código</th>
										<th>Estatus</th>
										<th>Descripción</th>
										<th>Fecha</th>
										<th>Usuario</th>
										<th>Cartera</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($gestiones as $gestion): ?>
									<tr>
										<td><?php echo $gestion->codigo ?></td>
										<td><?php echo $gestion->estatus ?></td>
										<td><?php echo $gestion->descripcion ?></td>
										<td><?php echo $gestion->fecha ?></td>
										<td><?php echo $gestion->usuario ?></td>
										<td><?php echo $gestion->cartera ?></td>
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
<?php \Core\View::render('master.footer') ?>
		