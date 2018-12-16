<?php \Core\View::render('master.header', ['title' => 'Asignaciones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content" data-json='<?php echo json_encode($estatus) ?>'>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-title">Selecciona el tipo de flujo</div>
						</div>
						<div class="panel-body">
							<div class="col-sm-10">
								<div class="form-group">
									<select name="estatus" id="estatus" class="form-control">
										<option value="productos">Productos</option>
										<option value="servicios">Servicios</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<button id="save" class="btn btn-primary btn-block">Guardar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
                <div id="chart_container">
					<div class="buttons-flow">
						<button id="delete-selected">Eliminar Seleccionado</button>
					</div>
                    <div class="flowchart-example-container" id="example"></div>
                </div>  
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer', ['scripts' => [
	'assets/scripts/flujo.js'
]]) ?>
		