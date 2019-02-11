<?php \Core\View::render('master.header', ['title' => 'pendientes']) ?>
    <div class="main">
        <div class="main-content">
        <!--- Tu contenido -->
            <!-- <div class="col-sm-12">
                    <iframe src= <?php echo \App\Config::DomainTomcat."InterfazGCnt/pendiente.xhtml" ?> frameborder="0" style="width: 100%; height: 800px;"></iframe>
            </div> -->

            <div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Aprovisionamiento </h3>
						</div>
						<div class="panel-body">


                            <div class="row">
							<div class="col-md-12">
						
								<ul id="tabsJustified" class="nav nav-tabs">
									<li class="nav-item active"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase active">Asignados</a></li>
									<li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase ">Todos</a></li>
								</ul>
								<br>
								<div id="tabsJustifiedContent" class="tab-content">
									<div id="home1" class="tab-pane fade active  in">
									<table class="table">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Producto</th>
                                                <th>Estatus</th>
                                                <th>Suscripción</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($carritos as $carrito): ?>
                                            

                                            <tr>
                                                <td><?php echo $carrito->cliente ?></td>
                                                <td><?php echo $carrito->producto ?></td>
                                                <td>
                                                    <?php echo \App\Models\Estatus::calculate($carrito->estatus,'carrito') ?>
                                                </td>
                                                <td><?php echo date('Y-m-d', strtotime( $carrito->fecha_compra)) ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal" data-titulo='<?php echo   $carrito->generacion ?>' data-json = '<?php echo json_encode( $carrito ) ?>' >Aprovicionar</button>
                                                </td>

                                            </tr>
                                        
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
									</div>
									<div id="profile1" class="tab-pane ">
									<table class="table">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Producto</th>
                                                <th>Estatus</th>
                                                <th>Suscripción</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($carritoall as $carrito): ?>
                                            

                                            <tr>
                                                <td><?php echo $carrito->cliente ?></td>
                                                <td><?php echo $carrito->producto ?></td>
                                                <td>
                                                    <?php echo \App\Models\Estatus::calculate($carrito->estatus,'carrito') ?>
                                                </td>
                                                <td><?php echo date('Y-m-d', strtotime( $carrito->fecha_compra)) ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal" data-titulo='<?php echo   $carrito->generacion ?>' data-json = '<?php echo json_encode( $carrito ) ?>' >Aprovicionar</button>
                                                </td>

                                            </tr>
                                        
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>


									</div>
							
                                    </div>
                                </div>
                            </div>



							
						</div>
					</div>
				</div>
        </div>

        <!-- Modal -->

        
            <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modalbody" class="modal-body" style="height: 600px;">
                    <div class="col-sm-12" >
                        <div class="form-group row" style=" margin-top: 2%;">
                            <div class="col-sm-5">
                            <label for="staticEmail" class=" col-form-label">Número de Venta:</label>
                            </div>
                            <div class="col-sm-7">
                            <label id="ventalabel" for="staticEmail" class=" col-form-label" style="    font-weight: 10 !important;"></label>
                            </div>
                        </div>
                  
                        <div class="form-group row" style=" margin-top: 2%;">
                            
                            <div class="col-sm-5">
                            <label for="staticEmail" class=" col-form-label">Nombre Organización:</label>
                            </div>
                            <div class="col-sm-7">
                            <label id="organizacionlabel" for="staticEmail" class=" col-form-label" style="    font-weight: 10 !important;"></label>
                            </div>

                        </div>

                        <div class="form-group row" style=" margin-top: 2%;">
                            
                            <div class="col-sm-5">
                            <label for="staticEmail" class=" col-form-label">Nombre del cliente:</label>
                            </div>
                            <div class="col-sm-7">
                            <label id="clientelabel" for="staticEmail" class=" col-form-label" style="    font-weight: 10 !important;"></label>
                            </div>

                        </div>

                     

                        <div class="form-group row" style=" margin-top: 2%;"  id="divurl">
                            <label for="staticEmail" class="col-sm-3 col-form-label">URL VDC:</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="urlinput" placeholder="URL VDC">
                            </div>


                            
                        </div>

                        <div class="form-group row" style=" margin-top: 2%;" id="divorg">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Siglas de Organización:</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="orginput" placeholder="Organizacion">
                        </div>

                        


                            
                        </div>
                        <div class="form-group row" style=" margin-top: 2%;">
                            <div class="col-sm-12" id="lista"></div>
                        </div>

                        <div class="form-group" id="divvelocidad">
                        <label for="sel1">Velocidad del cpu</label>
                        <select class="form-control" id="sel1">
                            <option>0.25</option>
                            <option>0.5</option>
                            <option>1</option>
                        </select>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="aprovisionar();" >Aprovicionar</button>
                </div>
                </div>
            </div>
            </div>

        <!-- end main -->

      <div>
      <table id="table1" style="width:100%">
  
        </table>
      </div>
    </div>

<?php \Core\View::render('master.footer',
['scripts' => [
    'assets/scripts/pendiente.js',
    'assets/scripts/jspdf.min.js',
    'assets/scripts/jspdf.plugin.autotable.min.js'
]]) ?>