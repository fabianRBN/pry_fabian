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
						<div class="panel-title">Configuracion de estados</div>
					</div>
                <div class="panel-body">

                    <div class="col-sm-6">  
                        <div class="form-group"> 
                        <label for="">Usuarios</label>
                            <select class="form-control">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">  
                        <div class="form-group"> 
                        <label for="">Estatus</label>
                        <select class="selectpicker form-control" multiple data-live-search="true">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                    </div>       
                 </div>
            </div>
        </div>
    </div>
</div>


<?php \Core\View::render('master.footer',['scripts' => ['assets/scripts/bootstrap-select.min.js']]) ?>