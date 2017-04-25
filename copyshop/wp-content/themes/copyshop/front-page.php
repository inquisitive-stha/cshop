<?php get_header();?>
<!--/#main-slider-->
<?php echo do_shortcode('[metaslider id=128]');?>

<!-- slider -->
<!-- conetent section -->
<!-- product catagory -->
<div class="pg-section">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-4">
				<?php get_sidebar('nav');?>
				
			</div>
			
			<!-- product list -->
			<div class="col-md-9 col-sm-8">
				<div class="product-list">
					<div class="row">
					<?php 
						$i=1;
						$args = array('post_type'=>'product','posts_per_page'=>8);
						$query= new WP_Query($args);
						while($query->have_posts()):$query->the_post();
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$count = $query->found_posts;
						if(($i==1)||($i%4==1)){echo '<div class="row">';}
					?>
						<div class="col-md-3 col-sm-6">
							<div class="product-block">
								<div class="product-img">
									<a href="<?php the_permalink();?>">
										<img src="<?php echo $image_url[0] ;?>" alt="<?php
$thumb_id = get_post_thumbnail_id(get_the_ID());
$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
if(count($alt)) echo $alt;
?>" title="Products"  >
										<i class="fa fa-shopping-cart"></i>
									</a>
								</div>
								
						<p><a href="<?php the_permalink();?>"><?php the_title();?></a></p>
						
						</div>
						</div>
						<?php if(($i%4==0)||($count==0)){echo '</div>';}?>
					<?php $i++; $count--;endwhile;
					wp_reset_query();
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- video -->
<div class="pg-section">
	<div class="container">
		<div class="row">
			<?php 
				$args = array('category_name'=>'home-content','posts_per_page'=>1,'order'=>'ASC');
				$query= new WP_Query($args);
				while($query->have_posts()):$query->the_post();
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			?>
			<div class="col-md-4 col-sm-4">
				<div class="video-section">
					<figure>
						<a href="https://www.google.de/maps/uv?hl=de&pb=!1s0x47bd0ea4484ba7a3:0x892b06cd20f441ed!2m5!2m2!1i80!2i80!3m1!2i100!3m1!7e115!4s/maps/place/copyshop%2Bffm%2523/@50.1125298,8.6853052,3a,75y,187.3h,90t/data%3D*213m4*211e1*213m2*211sGjeqMCpr27oAAAQvOtI6CQ*212e0*214m2*213m1*211s0x0:0x892b06cd20f441ed!5scopyshop+ffm%23+-+Google-Suche&imagekey=!1e2!2sGjeqMCpr27oAAAQvOtI6CQ&sa=X&ved=0ahUKEwjLjIXIi53OAhUEVRoKHUMVAVwQoB8IggEwCg"><img src="../wp-content/uploads/2016/07/laden_streetview_min.jpg" title="Laden Streetview" alt="Laden Photo" width="100%" height="280"></a>


					</figure>
				</div>

			</div>

			<div  class="col-md-8 col-sm-8">
				<div  class="text">
					<h2><?php the_title();?></h2>
					<p><?php the_content();?></p>
				</div>
			</div>
		<?php endwhile; wp_reset_query();?>
		</div>
	</div>
</div>

<!-- product slider -->



<!-- End of product slider -->

<div class="pg-section">
	<div class="container">
		<div class="row">
			<!-- video -->
			<div class="col-md-4 col-sm-4">
				<div class="video-section">
					<div class="banner page-block">
						<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
							<!-- Carousel items -->
 							<div class="carousel-inner">
								<div class="active item">
									<img src="<?php echo get_template_directory_uri();?>/images/hardcover.jpg" alt="hardcover" title="Hardcover Bindung">									
								</div>
								
								<div class="item">
									<img src="<?php echo get_template_directory_uri();?>/images/spiralbindung.jpg" title="Spiralbindung" alt="spiralbindung">
								</div>
								
								<div class="item">
									<img src="<?php echo get_template_directory_uri();?>/images/slide-img1.jpg" title="Klebebindung" alt="Klebebindung">
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>


			<div class="col-md-8 col-sm-8">
				<?php 
					$args = array('category_name'=>'home-content','offset'=>1, 'posts_per_page'=>2,'order'=>'ASC');
					$query= new WP_Query($args);
					while($query->have_posts()):$query->the_post();
					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				?>
			

			
				<div class="text">
					<h4><?php the_title();?></h4>
					<p><?php the_content();?></p>
				</div>
			
		<?php endwhile; wp_reset_query();?>
			</div>
			</div>
		</div>
	</div>
<?php get_footer();?>