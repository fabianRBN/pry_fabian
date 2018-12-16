<!-- END MAIN -->
<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; <?php echo date('Y') ?> <a href="<?php echo \App\Config::Domain ?>" target="_blank"><?php echo \App\Config::ClientName ?></a>. Todos los derechos reservados.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="<?php \Core\Router::assets('assets/vendor/jquery/jquery.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.jss') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/vendor/chartist/js/chartist.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/jquery.nestable.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/klorofil-common.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/vendor/toastr/toastr.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/angular.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/format.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/pagination.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/editor/trumbowyg.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/jquery-ui.min.js') ?>"></script>

	<script src="<?php \Core\Router::assets('assets/scripts/jquery.panzoom.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/jquery.mousewheel.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/moment.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/flujo/jquery.flowchart.min.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/inputs.js') ?>"></script>
	<script src="<?php \Core\Router::assets('assets/scripts/config.js') ?>"></script>

	<?php if(isset($scripts)): ?>
	<?php foreach($scripts as $script): ?>
	<script src="<?php \Core\Router::assets($script) ?>"></script>
	<?php endforeach ?>
	<?php endif ?>

	<script>
		
		$('.table').DataTable( {
			"aLengthMenu": [
				[25, 50, 100, 200, -1],
				[25, 50, 100, 200, "All"]
			],
    		"iDisplayLength": -1,
			"pagingType": "full_numbers",
			"language": {
				"lengthMenu": "Mostrando _MENU_ registros por pagina",
				"zeroRecords": "No se encontraron resultados",
				"info": "Mostrando pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No se encontraron resultados",
				"infoFiltered": "(filtrando de _MAX_ total de registros)",
				"search": "Buscar:",
				"paginate": {
					"first":      "Primero",
					"last":       "Ultimo",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
			}
		} )
	</script>
</body>

</html>
