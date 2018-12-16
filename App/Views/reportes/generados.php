<?php \Core\View::render('master.header', ['title' => 'Reportes generados']) ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Reportes generados</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Archivo</th>
										<th>Tamaño</th>
										<th>Fecha de creación</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($reportes as $reporte): ?>
									<tr>
										<td><a target="_blank" href="<?php echo $reporte['url'] ?>"><?php echo $reporte['file'] ?></a></td>
										<td><?php echo $reporte['size'] ?></td>
										<td><?php echo $reporte['date'] ?></td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<?php \Core\View::render('master.footer') ?>
		