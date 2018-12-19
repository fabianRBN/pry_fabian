
    <!-- ======= 1.09 footer Area ====== -->
    <footer class="secPdngT animated">
        <div class="w-100 blanco-bg d-flex f-justify-between f-align-center pa-ver-32 border-top pa-hor-15 f-column-768 " id="main-footer">
        <div>
          <img src="<?php \Core\Router::assets('assets/img/cnt-logo.png')?>">
          <span class="ma-ver-8">
            | Corporación Nacional de Telecomunicaciones © CNT lo que eres 2018.
            <!--Todos los derechos reservados-->
          </span>
        </div>
        <div class="ma-top-16-768">
          <a href="https://www.facebook.com/CNTEcuador/" target="_blank">
            <i class="fa fa-facebook-square"></i>
          </a>
          <a href="https://twitter.com/CNT_EC" target="_blank">
            <i class="fa fa-twitter-square"></i>
          </a>
          <a href="https://www.youtube.com/channel/UCWUe62T_Lmuk76bILKMRhTw" target="_blank">
            <i class="fa fa-youtube-square"></i>
          </a>
        </div>

      </div>
      <div id="number"></div>
    </footer>
    <!-- ======= /1.09 footer Area ====== -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php \Core\Router::assets('website/js/jquery.1.11.3.min.js') ?>"></script> <!-- jQuery -->
    <script src="<?php \Core\Router::assets('website/js/bootstrap.min.js') ?>"></script> <!-- Bootstrap -->
    <script src="<?php \Core\Router::assets('website/js/owl.carousel.min.js') ?>"></script> <!-- owlCarousel -->
    <script src="<?php \Core\Router::assets('website/js/waypoints.min.js') ?>"></script> <!-- waypoint -->
    <script src="<?php \Core\Router::assets('website/js/active.js') ?>"></script> <!-- active js -->
    <script src="<?php \Core\Router::assets('assets/scripts/moment.js') ?>"></script>
    <script src="<?php \Core\Router::assets('assets/vendor/toastr/toastr.js') ?>"></script>
    <script src="<?php \Core\Router::assets('assets/scripts/time-session.js') ?>"></script>

    <script src="<?php \Core\Router::assets('assets/scripts/config.js') ?>"></script>


    <?php if(isset($scripts)): ?>
	<?php foreach($scripts as $script): ?>
	<script src="<?php \Core\Router::assets($script) ?>"></script>
	<?php endforeach ?>
	<?php endif ?>



    </body>
</html>
