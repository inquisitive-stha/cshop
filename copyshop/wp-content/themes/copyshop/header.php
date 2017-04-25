<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php wp_title('|', true, 'right');?></title>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!-- parallex content slider -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/style2.css" />
<link rel='stylesheet' id='camera-css'  href='<?php echo get_template_directory_uri();?>/css/camera.css' type='text/css' media='all'> 
<!-- Fonts -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,600,700' rel='stylesheet' type='text/css'>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
<?php	do_action( 'storefront_before_header' ); ?>
<header>
	<div style="margin-top:0;" class="container">
	<?php do_action( 'copyshop_header_top' );?>
		<div class="row">
			<div class="col-md-4 col-sm-3">
				<div class="biz-logo">
				<?php if(has_custom_logo()):?>
					<?php copyshop_the_custom_logo(); ?>
				<?php else:?>
					<a href="<?php echo home_url();?>"><img style="max-width:90%;" src="<?php echo get_template_directory_uri();?>/images/logo.jpg" title="Copyshop FFM Logo" alt="CopyShop FFM Logo" class="img-responsive"></a>
				<?php endif;?>
				</div>
			</div>
			
			<div class="col-md-3 col-sm-3">
				<?php

				do_action( 'copyshop_skip_links' );

				/**
				* copyshop_social_media_links hook
				*
				* @hooked copyshop_social_media_links - 15
				* @hooked copyshop_secondary_navigation - 10
				*/	
				 ?>
			</div>
			
			<div class="col-md-5 col-sm-6">
				<div class="head-nav">
					<ul>
						<li><a href="<?php echo get_page_link('8');?>"><i class="fa fa-user"></i>Account</a></li>
						<li><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?>&nbsp;<i class="fa fa-shopping-cart"></i></a></li>
					</ul>
					<?php //do_action('copyshop_header_cart');?>
					
					<?php //woocommerce_mini_cart(); ?>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="navigation">
	<div style="margin-top:0;" class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<aside  class="navbar" role="navigation">
					<!-- nav bar collapse -->
					<article class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</article>
							<?php 
				/**
				* copyshop_main_nav hook
				*
				* @hooked storefront_primary_navigation - 60
				*/	
				do_action( 'copyshop_main_nav' ); ?>
					<article class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">	
						<ul id="main-menu" class="sm sm-blue">
							<li class="<?php if(is_page('startseite')){echo 'selected';}?>">
								<a href="<?php echo home_url();?>"><i class="fa fa-home">&nbsp;</i>Startseite</a>
								
							</li>
							
							<li class="<?php if(is_page('preisliste')){echo 'selected';}?>"><a href="<?php echo get_page_link('11');?>">Preisliste</a></li>
							
														
							<li class="<?php if(is_page('oeffnungszeiten')){echo 'selected';}?>"><a href="<?php echo get_page_link(311);?>">Öffnungszeiten</a></li>

							<li class="<?php if(is_page('bewertung')){echo 'selected';}?>"><a href="https://www.google.de/search?q=CopyShop&ludocid=9884001285285626349#lrd=0x0:0x892b06cd20f441ed,1" method="get" target="_blank">Bewertung</a></li>
							
							
							<li>
								<a href="<?php echo get_page_link(296);?>">Impressum</a>
							<!-- first level -->
							<!--	<ul> -->
								<!--	<li><a href="#">Introduction</a></li>  -->
								<!--	<li><a href="#">Message form principal</a></li>  -->
							<!--	</ul> -->
							</li>
						<!--	<li class="<?php if(is_page('uber-uns')){echo 'selected';}?>"><a href="<?php echo get_page_link(182);?>">Über uns</a></li> -->
							
							<li class="<?php if(is_page('kontakt')){echo 'selected';}?>"><a href="<?php echo get_page_link('46');?>">Kontakt</a></li>
						</ul>
						
					</article>
				</aside>
			</div>
			
			<div style="height:42px;" class="col-md-3 col-sm-3">
			
				<div class="rgt-nav">

					<ul>
						<!-- search -->
						<li class="searchbar">
							<div class="drop-search">
							<?php get_product_search_form();?>
								
							</div>
						</li>
				   </ul>
				</div>
			</div>
		</div>
	</div>
</div>
