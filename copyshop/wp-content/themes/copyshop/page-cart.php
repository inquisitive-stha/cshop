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


	<?php while(have_posts()):the_post();?>
		<p><?php the_content();?></p>
	<?php endwhile;?>
	</div>
<?php get_footer();?>