<footer><!--footer start-->

	<div class="container">
		<div class="footer-top">
			<div class="row">
				<div class="col-md-4 col-sm-4">
				<?php 
				$args = array('category_name'=>'about','posts_per_page'=>1,'order'=>'ASC');
				$query= new WP_Query($args);
				while($query->have_posts()):$query->the_post();
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			?>
					<div class="intro">
						<h4><?php the_title();?></h4>
						<div class="text">
							<p><?php my_excerpt(50);?>	</p>
							<a href="<?php echo get_page_link(182);?>">Weiterlesen<i class="fa  fa-long-arrow-right"></i></a>
						</div>
					</div>
				<?php endwhile;wp_reset_query();?>
				</div>

				<div class="col-md-4 col-sm-4 ">
					<div class="foot-nav">
						<h4>Navigation</h4>
						<div class="text">
							<ul>
								<li><a href="<?php echo home_url();?>">Startseite</a></li>

								<li><a href="<?php echo get_page_link(11)?>">Preisliste</a></li>

								<li><a href="<?php echo get_page_link(207)?>">Versand</a></li>

								<li><a href="<?php echo get_page_link(297);?>">ABG</a></li>
									
								<li><a href="<?php echo get_page_link(403)?>">Widerrufsrecht</a></li>

								<li><a href="<?php echo get_page_link(46);?>">Kontakt</a></li>

								
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4">
					<div class="foot-cnt">
						<h4>Kontaktieren Sie uns</h4>
						<div class="text">
							<h4>COPYSHOP FFM</h4>
							<p>Berliner Strasse 6</p>
							<p>D-60311 Frankfurt am Main</p>
							<p>Telefon: 069/2199 8285</p>
							<p>Fax: 069/2199 8287</p>
							<p>Email: info@copyshopffm.de</p>
							<p>Web: www.copyshopffm.de</p>
						</div>

						<div class="social-media">


	<a class="facebook" target="_blank" href="https://www.facebook.com/CopyShopFFM/"><i class="fa fa-facebook">.</i></a>





							<a class="googleplus" href="https://plus.google.com/b/111545957399794506709/111545957399794506709"><i class="fa fa-google-plus">.</i></a>

							<a class="twitter" href="https://twitter.com/CopyShop_FFM"><i class="fa fa-twitter">.</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	


	<div class="footer-bottom">
		<p>Copyright &copy; <?php the_time('Y')?> Copyshop FFM. Alle Rechte vorbehalten.</p>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo get_template_directory_uri();?>/js/jquery-1.11.2.js"></script>
<!-- Include all compiled plugins (below), or in>clude individual files as needed -->
<script src="<?php echo get_template_directory_uri();?>/js/bootstrap.js"></script>
<script type='text/javascript' src='<?php echo get_template_directory_uri();?>/js/jquery.mobile.customized.min.js'></script>
<script type='text/javascript' src='<?php echo get_template_directory_uri();?>/js/jquery.easing.1.3.js'></script> 
<!-- nav-menu script -->
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.smartmenus.js"></script>
<script type="text/javascript">
	$(function() {
		$('#main-menu').smartmenus({
			subMenusSubOffsetX: 1,
			subMenusSubOffsetY: -20
		});
	});
</script>

<!--parallex slider -->
<!-- <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.cslider.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/modernizr.custom.28468.js"></script>
<script type="text/javascript">
	$(function() {
	
		$('#da-slider').cslider({
			autoplay	: true,
			bgincrement	: 450
		});
	
	});
</script> -->

<!-- owl carousel -->
<script src="<?php echo get_template_directory_uri();?>/js/owl.carousel.js"></script>
<script>
	$(document).ready(function() {
	$('dt.variation-Farbauswahl').remove();
	$('dd.variation-Farbauswahl').remove();
	  $("#owl-demo1").owlCarousel({
		items : 3,
		itemsDesktopSmall : [979, 3],
		itemsTablet : [768, 2],
		itemsMobile : [479, 1],
		speed : 2000,
		lazyLoad : true,
		navigation : true,
		navigationText : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		autoplay : false,
		pagination : false,

	  });

	});
</script>
<script>
$(document).ready(function(){
//$("#pa_papier-format option[value='a3']").remove();   // remove a3 option from dropdown
    $('[data-toggle="tooltip"]').tooltip();
    $("a").tooltip();
});
 
</script>
<?php if( is_singular( 'product' )):?>

<script type="text/javascript">
	var stickyTop = $('#stickyBanner').offset().top-100;
	var colOffset = $('.equalheight').offset().top;

	var stickyBottom = $('#stickyBottom').offset().top;
	var divheight = $( '#stickyBanner' ).height();
	var viewportwidth = $(window).width();
	var viewportheight= $(window).height();
	var top = $(window).scrollTop();

	//console.log(stickyBottom - divheight+'   '+top+' '+stickyTop);
if (viewportwidth>740) {
	$(window).on( 'scroll', function(){
	if ($(window).scrollTop() >= stickyTop) {

			/*$('#stickyBanner').css({position: "fixed", top: "100px"});*/
			$('#stickyBanner').addClass('sticky');
			
		}
		if(($(window).scrollTop() < stickyTop)){
			$('#stickyBanner').removeClass('sticky');
		}
		if(($(window).scrollTop()>stickyBottom - divheight-95 )){
			
			$('#stickyBanner').removeClass('sticky');
			$('#stickyBanner').addClass('stickyBottom');
			

		}else if(($(window).scrollTop() <= stickyBottom - divheight-95 )){
			$('#stickyBanner').removeClass('stickyBottom');
		}
});
}else{
	$('#stickyBanner').removeClass('stickyBottom');
	$('#stickyBanner').removeClass('sticky');
	$('.row').removeClass('myrow');
	$('col-md-8 col-sm-8').removeClass('mycol');
}
	
		
	
</script>
<?php endif;?>
<?php wp_footer();?>
</footer><!--footerEnd-->


</body>
</html>
