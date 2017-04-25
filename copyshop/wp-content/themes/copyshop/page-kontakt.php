<?php get_header();?>
<div class="before-main">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
</div>
<div class="pg-section">
	<div class="container">
		<div class="contact">
			<div class="text">
				<p><?php the_content();?></p>
			</div>
			<div class="row">
				<div class="col-md-3">
					<?php get_sidebar('nav');?>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="cnt-info">
								<h3>COPY SHOP FFM</h3>
								<p>Berliner Strasse 6</p>
								<p>(Hinter Stadtbücherei Frankfurt)</p>	
								<p>D-60311 Frankfurt am Main</p>
								<p>Telephone: 069/2199 8285</p>
								<p>Fax: 069/2199 8287</p>
								<p>Email: info@copyshopffm.de</p>
								<p>Web: www.copyshopffm.de</p>
								<div class="social-media">
										<a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
										<a class="googleplus" href="#"><i class="fa fa-google-plus"></i></a>
										<a class="twitter" href="#"><i class="fa fa-twitter"></i></a>

								</div>

							</div>	
							
						</div>
						<div class="col-md-6 col-sm-6">
						<h2>Büro:</h2>
						<p>AGS Invesment GmbH</p>
						<p>Robert Dissmann-Strasse 6</p>
						<p>D-65936 Frankfurt am Main</p>
						
							
						</div>
					</div>
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d20469.848968116!2d8.694142560913075!3d50.11003953960895!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x892b06cd20f441ed!2sCopyshop+FFM!5e0!3m2!1sen!2snp!4v1467100539380" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
					<div class="text">
						<?php echo do_shortcode('[contact-form-7 id="186" title="Contact form 1"]');?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php get_footer();?>