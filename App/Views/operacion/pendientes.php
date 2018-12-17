<?php \Core\View::render('master.header', ['title' => 'pendientes']) ?>
    <div class="main">
        <div class="main-content">
        <!--- Tu contenido -->
            <div class="col-sm-12">
                    <iframe src="https://smart.cntcloud2.com:8443/InterfazGCnt/pendiente.xhtml" frameborder="0" style="width: 100%; height: 800px;"></iframe>
            </div>
        </div>
    </div>
<?php \Core\View::render('master.footer') ?>