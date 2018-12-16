<?php \Core\View::render('master.header', ['title' => '']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Información de cliente
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <p>
                                    </p>
                                    <p>
                                        <b>Nombre:</b> <?php echo $cliente->nombre . ' ' . $cliente->apellidos ?>
                                    </p>
                                    <p>
                                        <b>Empresa:</b> <?php echo $cliente->empresa?>
                                    </p>
                                    <p>
                                        <b>Teléfono:</b> <?php echo $cliente->telefono ?>
                                    </p>
                                    <p>
                                        <b>Dirección:</b> <?php echo $cliente->direccion ?>
                                    </p>
                                    <p>
                                        <b>Ciudad:</b> <?php echo $cliente->ciudad ?>
                                    </p>
                                    <p>
                                        <b>País:</b> <?php echo $cliente->pais ?>
                                    </p>
                                    <p>
                                        <b>Correo:</b> <?php echo $cliente->correo ?>
                                    </p>
                                    <p>
                                        <b>Tipo de cliente:</b> <?php echo $cliente->tipo->nombre?>
                                    </p>
                                    <p>
                                        <b>Sector:</b> <?php echo $cliente->sector->nombre ?>
                                    </p>
                                </div>
                                <div class="panel-footer">
                                </div>
                                <div class="panel-footer">
                                </div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		