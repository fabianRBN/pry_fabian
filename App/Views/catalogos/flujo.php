<?php \Core\View::render('master.header', ['title' => 'Asignaciones']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content" data-tipo="<?php echo $_GET['tipo'] ?>" data-id="<?php echo $producto->id ?>" data-json='<?php echo json_encode($estatus) ?>'>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-title">Clonar flujo al <?php echo ($_GET['tipo'] == 'carrito' ? 'producto' : 'servicio') ?> <?php echo $producto->nombre ?></div>
						</div>
						<div class="panel-body">
							<form action="<?php \Core\Router::url('catalogos/cloneflujo') ?>">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo $producto->id ?>">
                                        <input type="hidden" name="tipo" value="<?php echo $_GET['tipo'] ?>">
                                        <select name="from" id="estatus" class="form-control">
                                            <?php foreach($products as $product): ?>
                                            <option value="<?php echo $product->id?>"><?php echo $product->nombre?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-block">Clonar</button>
                                </div>
                            </form>
                            <div class="col-sm-6 col-sm-offset-3">
								<button id="save" class="btn btn-block btn-primary btn-block">Guardar</button>
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
	'assets/scripts/flujo-editor.js'
]]) ?>
		