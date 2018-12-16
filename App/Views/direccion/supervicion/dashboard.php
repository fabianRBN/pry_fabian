<?php \Core\View::render('master.header', ['title' => 'Dashboard']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="colum">
					<div class=" charts col-sm-4 chart-1">
						<div class="card">
							<h4 class="text-muted text-center" style=" height: 38px !important; margin-bottom: 0px !important;">Cargando datos..</h4>
							<img src="<?php \Core\Router::assets('assets/img/no-data.png') ?>" alt="">
							<canvas id="chart-1" height="183"></canvas>
						</div>
					</div>
					<div class=" charts col-sm-4 chart-2">
						<div class="card">
							<h4 class="text-muted text-center" style=" height: 38px !important; margin-bottom: 0px !important;">Cargando datos..</h4>
							<img src="<?php \Core\Router::assets('assets/img/no-data.png') ?>" alt="">
							<canvas id="chart-2" height="183"></canvas>
						</div>
					</div>
					<div class=" charts col-sm-4 chart-3">
						<div class="card">
							<h4 class="text-muted text-center" style=" height: 38px !important; margin-bottom: 0px !important;">Cargando datos..</h4>
							<img src="<?php \Core\Router::assets('assets/img/no-data.png') ?>" alt="">
							<canvas id="chart-3" height="183"></canvas>
						</div>
					</div>
					<div class=" charts col-sm-4 chart-4">
						<div class="card">
							<h4 class="text-muted text-center" style=" height: 38px !important; margin-bottom: 0px !important;">Cargando datos..</h4>
							<img src="<?php \Core\Router::assets('assets/img/no-data.png') ?>" alt="">
							<canvas id="chart-4" height="183"></canvas>
						</div>
					</div>
					<div class=" charts col-sm-4 chart-5">
						<div class="card">
							<h4 class="text-muted text-center" style=" height: 38px !important; margin-bottom: 0px !important;">Cargando datos..</h4>
							<img src="<?php \Core\Router::assets('assets/img/no-data.png') ?>" alt="">
							<canvas id="chart-5" height="183"></canvas>
						</div>
					</div>
					<div class=" charts col-sm-4 chart-6">
						<div class="card">
							<h4 class="text-muted text-center" style=" height: 38px !important; margin-bottom: 0px !important;">Cargando datos..</h4>
							<img src="<?php \Core\Router::assets('assets/img/no-data.png') ?>" alt="">
							<canvas id="chart-6" height="183"></canvas>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer', [
	'scripts' => [
		'assets/scripts/Chart.min.js',
		'assets/scripts/dash.js'
	]
]) ?>
		