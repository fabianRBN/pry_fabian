<?php \Core\View::render('website.header', ['title' => 'Inicio']) ?>
  <!-- ======= 2.01 Page Title Area ====== -->

    <div class="pageTitleArea animated">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="pageTitle">
    					<div class="h2">Contacto</div>
    					<ul class="pageIndicate">
    						<li><a href="">Innovasys</a></li>
    						<li><a href="">Contacto</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <!-- ======= /2.01 Page Title Area ====== -->

	<div class="contactArea secPdng animated">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="contactTxt">
						<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros <br>et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<form id="ajax-contact" action="mail.php" method="post" class="contactForm">
						<div class="contactInput">
							<input id="name" name="name" type="text" placeholder="Nombre *">
						</div>
						<div class="contactInput">
							<input id="email" name="email" type="email" placeholder="Correo  electrónico *">
						</div>
						<div class="contactInput">
							<input id="phoneNo" name="phoneNo" type="text" placeholder="Teléfono *">
						</div>
						<div class="contactInput">
							<input id="phoneNo" name="phoneNo" type="text" placeholder="Asunto*">
						</div>
						<div class="contactMsg">
							<textarea id="contactMsg" name="contactMsg" placeholder="Mensaje"></textarea>
						</div>
						<div class="contactSubmit">
							<input id="submit" name="submit" type="submit" value="Enviar">
						</div>
						<div id="form-messages"></div>
					</form>
				</div>
				<div class="col-md-6">
					<div class="contactInfoCell">
						<div class="singleInfo">
							<div class="h4">Lorem</div>
							<div class="singleContactInfo"><span>Lorem:</span> <a href="tel:+ 021-5432-145">+ 021-5432-145</a></div>
							<div class="singleContactInfo"><span>Lorem:</span> <a href="tel:+ 021-5432-145">+ 021-5432-145</a></div>
						</div>
						<div class="singleInfo">
							<div class="h4">Email</div>
							<div class="singleContactInfo"><span>Lorem:</span> <a href="#">email@sitename.com</a></div>
							<div class="singleContactInfo"><span>Lorem</span>  <a href="#">support@sitename.com</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php \Core\View::render('website.footer') ?>
		