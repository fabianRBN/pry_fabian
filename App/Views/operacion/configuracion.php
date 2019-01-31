<?php \Core\View::render('master.header', ['title' => 'Configuracion']) ?>

<div class="main">
        <div class="main-content">
        <!--- Tu contenido -->
            <!-- <div class="col-sm-12">
                    <iframe src= <?php echo \App\Config::DomainTomcat."InterfazGCnt/pendiente.xhtml" ?> frameborder="0" style="width: 100%; height: 800px;"></iframe>
            </div> -->
        
            <div class="col-sm-12">

                <div class="panel" style="height: 200px;">
                    <div class="panel-heading">
						<div class="panel-title">Usuarios a notificar</div>
					</div>
                <div class="panel-body">


                    <div class="col-sm-6">  
                        <div class="form-group"> 
                        <label for="">Estatus</label>
                            <select id="selectareas" class="form-control">
                                <?php foreach($estatus as $estatu): ?>
                                    <option  value="<?php echo $estatu->id ?>" > <?php echo $estatu->nombre ?> </option>
                                <?php endforeach ?>
                              
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">  
                        <div class="form-group"> 
                        <label for="">Roles</label>
                            <select id="selectpermisos" class="form-control">
                                <?php foreach($permisos as $permiso): ?>
                                    <option value="<?php echo $permiso->id ?>" > <?php echo $permiso->nombre ?> </option>
                                <?php endforeach ?>
                              
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
						<button id="button-send" class="btn btn-primary btn-block">Guardar</button>
						<br>
					</div> 
                 </div>
            </div>


            

            <div class="panel" >
                    <div class="panel-heading">
						<div class="panel-title">Usuarios a notificar</div>
					</div>
                <div class="panel-body">

                <table class="table">
				<thead>
					<tr>
						<th>Estatus</th>
						<th>Roles</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($arearnotificadas as $arearnotificada): ?>
					<tr>
						<td><?php echo $arearnotificada->estatus ?></td>
						<td><?php echo $arearnotificada->permiso ?></td>
                        <td><button class="btn btn-primary" onclick="deleteAreaNotificada(<?php  echo $arearnotificada->id ?>)">Eliminar</button></td>
					</tr>
					<?php endforeach ?>
				</tbody>
				    </table>

            </div>
            
            </div>

            
        </div>
    </div>
</div>

<div id="url" data-url='<?php echo \App\Config::Domain ?>'></div>
<?php \Core\View::render('master.footer',['scripts' => ['assets/scripts/configuracion.js']]) ?>