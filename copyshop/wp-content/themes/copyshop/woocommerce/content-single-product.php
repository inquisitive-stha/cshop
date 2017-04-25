<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
global $product;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	<div class="row myrow">
		<div class="col-md-8 col-sm-8 mycol">
			<div class="summary entry-summary">
	
			
		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>


		</div><!-- .summary -->
		
	</div>
		<div class="col-md-4 col-sm-4 equalheight" style="position:relative;">
			<div class="side-content">
					<div class="video-section">
						<div class="banner page-block">
							<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
								<!-- Carousel items -->
								<div class="carousel-inner">
									<div class="active item">
										<img src="<?php echo get_template_directory_uri()?>/images/slide-img1.jpg" alt="">									
									</div>
									
									<div class="item">
										<img src="<?php echo get_template_directory_uri()?>/images/slide-img2.jpg" alt="">
									</div>
									
									<div class="item">
										<img src="<?php echo get_template_directory_uri()?>/images/slide-img1.jpg" alt="">
									</div>
								</div>
							</div>
						</div>
	
					</div>
					
					<!-- price table -->
					<div class="price-table" id="stickyBanner">
						<h4 class="title">Summe</h4>
						<div class="text">
							<div class="table-responsive">
								<table id="myTable" class="table">
									<tbody>
										<tr id="bindungCost">
											<th>Bindung(Pro Stück*)</th>
											<td  style="float:right">
												 <span id="bindungtotal" class="text-default">0,00 € </span>
											</td>
										</tr>
										<tr class="cart-subtotals" style="background: #f1f1f1;">
											<th>Summe</th>
											<td style="float:right">
											<span id="grandtotal" class="text-default">€ 0,00</span>
											</td>
										</tr>
										
										<tr class="cart-subtotals">
											<td><p>inkl. 19% MwSt. </p></td>
										</tr>
										<tr>
											<td>
												<p>zzgl. Versand</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<button type="submit" form="form-<?php echo $product->id;?>" class="btn-log" title="Artikel in den Warenkorb legen">In den Warenkorb</button>
							<div class="error-message" style="color:#f50;"></div>
							
						</div>
					</div>
				</div>
		</div>
		
	</div>
	<div class="links" id="stickyBottom">
	<?php global $woocommerce;


	echo '<a class="btn-log" href="' . $woocommerce->cart->get_checkout_url() . '" title="' . __( 'Auschecken' ) . '">' . __( 'Auschecken' ) . '</a>';
?>	<button class="btn-log" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePrice" aria-expanded="true" aria-controls="collapsePrice">Preis im Detail</button>
		
		<button type="submit" form="form-<?php echo $product->id;?>" class="btn-log" title="Artikel in den Warenkorb legen">In den Warenkorb</button>
	</div>
	<div id="collapsePrice" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
	<div class="panel-body">
		<?php $id=get_the_id(); 
// echo $id;
?>
		<?php 
		if($id==58):      		// $id = priduct id
			$post_id = 303; 		//$post_id = post id where price is listed

		 elseif($id == 54):
			$post_id = 303;

/*		 elseif($id==):
			$post_id =;

		 elseif($id==):
			$post_id =;

		 elseif($id==):
			$post_id =;
*/
		 endif;?>
		<?php
            
            $queried_post = get_post($post_id);
            ?>
      <h2 class="title"><?php echo $queried_post->post_title; ?></h2>
      
      <?php echo $queried_post->post_content; ?>
	</div>
</div>
<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

