<?php \Core\View::render('master.header', ['title' => 'Asignaciones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-title">Selecciona la cartera</div>
						</div>
						<div class="panel-body">
							<div class="col-sm-7">
								<div class="form-group">
									<select name="cartera" id="cartera" class="form-control">
										<?php foreach($carteras as $cartera): ?>
										<option value="<?php echo $cartera->id ?>"><?php echo $cartera->id . ' - ' . $cartera->nombre ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<button id="change" class="btn btn-primary btn-block">Seleccionar</button>
							</div>
							<div class="col-sm-3">
								<button disabled id="save" class="btn btn-success btn-block">Guardar cambios</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-title">
								<span id="cartera-nombre">Cartera</span>
							</div>
						</div>
						<div class="panel-body dd dd-cartera"  data-tipo="cartera">
							<h4 class="hide-on-load">No se ha seleccionado la cartera</h4>
							<ol class="dd-list"></ol>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-title">
								Usuarios
							</div>
						</div>
						<div class="panel-body dd dd-usuarios"  data-tipo="usuarios">
							<h4 class="hide-on-load">No se ha seleccionado la cartera</h4>
							<ol class="dd-list"></ol>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer', ['scripts' => [
	'assets/scripts/asignaciones.js'
]]) ?>
		