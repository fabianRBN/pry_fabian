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
									<option value="todos" <?php if(isset($_GET['codigo'])){  if ($_GET['codigo'] == 'todos') echo ' selected="selected"'; }  ?> >Todos</option>
									<?php foreach($codigos as $codigo): ?>
									<option value="<?php echo $codigo->nombre ?>" <?php if(isset($_GET['codigo'])){  if ($_GET['codigo'] == $codigo->nombre) echo ' selected="selected"'; }  ?> ><?php echo $codigo->nombre ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="">Tipo de reporte</label>
								<select name="reporte" class="form-control">
									<option value="todos" <?php if(isset($_GET['reporte'])){  if ($_GET['reporte'] == 'todos') echo ' selected="selected"'; }  ?> >Todos</option>
									<option value="1" <?php if(isset($_GET['reporte'])){  if ($_GET['reporte'] == '1') echo ' selected="selected"'; }  ?> >Clientes por producto</option>
									<option value="2" <?php if(isset($_GET['reporte'])){  if ($_GET['reporte'] == '2') echo ' selected="selected"'; }  ?> >Clientes por estado</option>
									<option value="3" <?php if(isset($_GET['reporte'])){  if ($_GET['reporte'] == '3') echo ' selected="selected"'; }  ?> >Solicitudes rechazadas</option>
									<option value="4" <?php if(isset($_GET['reporte'])){  if ($_GET['reporte'] == '4') echo ' selected="selected"'; }  ?> >Venta por fecha</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="">Fecha inicio</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input name="fecha_inicio" value="<?php if(isset($_GET['fecha_inicio'])){ echo $_GET['fecha_inicio']; }else{ echo date('Y-m-d');} ?>" class="form-control" placeholder="Fecha inicio" type="date">
								</div>
							</div>
							<div class="col-sm-3">
								<label for="">Fecha fin</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input name="fecha_fin" value="<?php if(isset($_GET['fecha_fin'])){ echo $_GET['fecha_fin']; }else{ echo date('Y-m-d');} ?>" class="form-control" placeholder="Fecha fin" type="date">
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
										<?php foreach($names as $name): ?>
										<th><?php echo $name ?></th>
										<?php endforeach ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($gestiones as $gestion): ?>
									<?php $gestion = (array) $gestion ?>
									<tr>
										<?php foreach($names as $name => $value): ?>
										<td><?php echo $gestion[$name] ?></td>
										<?php endforeach ?>
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
		