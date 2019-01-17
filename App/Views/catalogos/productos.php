<?php \Core\View::render('master.header', ['title' => 'Productos']) ?>
		<div class="main" ng-app="app">
			<!-- MAIN CONTENT -->
			<div class="main-content" ng-controller="Products">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Registra un producto</h3>
						</div>
						<div class="panel-body no-padding">
                        <div class="col-sm-12">
								<div class="col-sm-4">
                                <label for="">Nombre</label>
									<div class="form-group">
										<input class="form-control" data-required="true" name="nombre" ng-model="product.nombre" producto-name="nombre" type="text" placeholder="Nombre">
									</div>
								</div>
                                <div class="col-sm-4">
                                <label for="">Precio</label>
									<div class="form-group">
										<input class="form-control" data-required="true" name="precio" ng-model="product.precio"  producto-name="precio" id="price" type="text" placeholder="Precio del producto">
									</div>
								</div>
                                <div class="col-sm-4">
                                <label for="">Tipo de pago</label>
                                    <select ng-model="product.tipo_pago" name="tipo_pago" id="tipo_pago" class="form-control">
                                        <option>Tipo de pago</option>
                                        <option ng-value="0" >Diario</option>
                                        <option ng-value="1" >Semanal</option>
                                        <option ng-value="2" >Quincenal</option>
                                        <option ng-value="3" >Mensual</option>
                                        <option ng-value="4" >Anual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                <label for="">Categoría</label>
                                    <select ng-model="product.categoria" name="categoria" id="categoria" class="form-control">
                                        <?php foreach($categorias as $categoria): ?>
                                        <option ng-value="<?php echo $categoria->id ?>" ><?php echo $categoria->nombre ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">
                                            Orden
                                        </label>
                                        <!-- <input type="file" ng-model="product.imagen"  accept="image/*" onchange="angular.element(this).scope().uploadFile()"/>
                                         -->
										<input class="form-control" data-required="true" name="orden" ng-model="product.orden"  producto-name="orden" id="orden" type="number"   placeholder="Orden del producto">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">
                                            Tipo de producto
                                        </label>
                                        <select ng-model="product.tipo_Web" name="tipo_Web" id="tipo_Web" class="form-control" >
                                                
                                                <option ng-value="0" >VCD</option>
                                                <option ng-value="1" >Servidores Virtuales</option>
                                                <option ng-value="2" >Otros</option>
                                                
                                        </select>

                                        
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-12">
                                <br>
                                </div>
                                <!--<div class="col-sm-12">
                                    <label for="">Lista de opciones </label>
                                    <input name="tags" class="form-control input-tags" id="tags" value="foo,bar,baz" />
                                </div>
                                <div class="col-sm-12">
                                    <br>
                                </div>-->
                                <div class="col-sm-12">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            Venta
                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.venta" name="venta" type="checkbox">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            Próximamente
                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.proximamente" name="proximamente" type="checkbox">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            Demo
                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.demo" name="demo" type="checkbox">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            Activo
                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.activo" name="activo" type="checkbox">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            Configurable
                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.configurable" name="configurable" type="checkbox">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                        Generacion Automatica

                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.generacion" name="generacion" type="checkbox">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                        Mostrar Labels

                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.mostrar_label" name="mostrar_label" type="checkbox">
                                        </label>
                                    </div>
                                </div>

                                

								<div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            Venta de precio real
                                        </label>
                                        <label class="fancy-radio">
                                            <input ng-model="product.venta_precio_real" name="venta_precio_real" type="checkbox">
                                        </label>
                                    </div>
                                </div>

                         

                                <br>
								
                                <div class="col-sm-12" style="margin-top: 2%;">
                                    <div class="form-group">
                                        <label for="">
                                            Cargar Imagen
                                        </label>
                                        <!-- <input type="file" ng-model="product.imagen"  accept="image/*" onchange="angular.element(this).scope().uploadFile()"/>
                                         -->
                                         <div >
                                            <img class="thumb" ng-src="{{stepsModel}}" />
                                        </div>

                                        <input type='file' name='imagen' ng-model-instant 
                                                            onchange="angular.element(this).scope().imageUpload(event)" />

                                    </div>
                                </div>
							
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Información de este produto</label>
                                    <textarea producto-name="descripcion" ng-model="product.descripcion" name="descripcion" id="editor" cols="30" rows="10"></textarea>
                                </div>
								<div class="col-sm-12">
                                    <label for="">Opciones de producto</label>
                                    <br>
                                </div>
                                <div class="col-sm-12" ng-repeat="option in product.opciones">
                                    <div class="col-sm-12 text-left">
                                    <a href="" ng-if="!option.exist" ng-click="deleteOption($index)" class="btn close"><i class="lnr lnr-cross"></i></a> <br></div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input class="form-control" ng-model="option.nombre" name="nombre" type="text" placeholder="Nombre de la opción">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input class="form-control price" ng-disabled="checkType(option)" ng-model="option.precio" name="precio" type="text" placeholder="Precio de la opción">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <select ng-model="option.tipo" ng-change="changeType($index)" name="tipo" id="tipo" class="form-control">
                                            <option ng-selected ng-value="0">Tipo de opción</option>
                                            <option ng-value="'1'">Rango de Numeros</option>
                                            <option ng-value="'2'">Caja de texto</option>
                                            <option ng-value="'4'">Activador</option>
                                            <option ng-value="'5'">Caja de selección</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12"><br></div>
                                    <div  ng-if="option.tipo == '1'">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control" ng-model="option.min" name="min" type="number" placeholder="Valor mínimo">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control" ng-model="option.max" name="max" type="number" placeholder="Valor máximo">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control" ng-model="option.valor" name="valor" type="number" placeholder="Valor por defecto">
                                            </div>
                                        </div>
                                    </div>
                                    <div  ng-if="option.tipo == '2'">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input class="form-control" ng-model="option.valor" name="min" type="text" placeholder="Valor por defecto">
                                            </div>
                                        </div>
                                    </div>
                                    <div  ng-if="option.tipo == '5'">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input class="form-control" ng-model="option.opciones" name="min" type="text" placeholder="Opciones del selección separadas por coma (Opcion 1,Opcion 2)">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input class="form-control" ng-model="option.opciones_precio" name="min" type="text" placeholder="Precio de cada selección separadas por coma (10.00,11.00)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12"><hr></div>
                                </div>
                                <div class="col-sm-12">
                                    <button ng-click="addOption()" class="btn btn-block">Añadir nueva opcion</button>
                                    <br>
                                </div>
                                <div class="col-sm-12">
									<button ng-click="save()" id="button-send" class="btn btn-primary btn-block">Guardar</button>
									<br>
								</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Productos &nbsp;&nbsp;<a style="color: #fff !important;" href="<?php \Core\Router::url('catalogos/download-masters') ?>" class="btn btn-primary">Descargar Maestros</a></h3> 
                          
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Precio</th>
										<th>Opciones</th>
										<th>Tipo de pago</th>
										<th>Cetagoria</th>
										<th>Fecha de creación</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach($productos as $producto): ?>
                                    <tr>
                                        <td><?php echo $producto->nombre ?></td>
                                        <td><?php echo '$' . number_format($producto->precio,2) ?></td>
                                        <td><?php echo count($producto->opciones) ?></td>
                                        <td>
                                            <?php if($producto->tipo_pago == 0): ?>
                                            Diario
                                            <?php elseif($producto->tipo_pago == 1): ?>
                                            Semanal
                                            <?php elseif($producto->tipo_pago == 2): ?>
                                            Quincenal
                                            <?php elseif($producto->tipo_pago == 3): ?>
                                            Mensual
                                            <?php elseif($producto->tipo_pago == 4): ?>
                                            Anual
                                            <?php endif ?>
                                        </td>
                                        <td><?php echo $producto->fecha_creacion ?></td>
                                        <td><?php echo \App\Models\Categoria::findBy($producto->categoria)->nombre ?></td>
                                        <td>
                                            <a data-id="<?php echo $producto->id ?>" class="btn btn-primary productos">Editar</a>&nbsp;<a href="<?php \Core\Router::url('catalogos/flujo?id=' . $producto->id . '&tipo=carrito') ?>" class="btn btn-success productos">Flujo de Estatus</a></td>
                                    </tr>
                                    <?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
            <!-- Modals -->


			<!-- END MAIN CONTENT -->
		</div>
		<div id="url" data-url='<?php echo \App\Config::Domain ?>'></div>
<?php \Core\View::render('master.footerProductos',['scripts' => [
	'assets/scripts/productos.js'
]]) ?>
		