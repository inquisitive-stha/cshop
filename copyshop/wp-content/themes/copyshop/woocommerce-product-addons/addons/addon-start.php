<div class="<?php if ( 1 == $required ) echo 'required-product-addon'; ?> product-addon product-addon-<?php echo sanitize_title( $name ); ?>">

	<?php do_action( 'wc_product_addon_start', $addon ); ?>
<div class="row">
	<div class="col-md-11">
		<?php if ( $name ) : ?>
		<h5 class="addon-name"><?php echo wptexturize( $name ); ?> <?php if ( 1 == $required ) echo '<abbr class="required" title="' . __( 'Required field', 'woocommerce-product-addons' ) . '">*</abbr>'; ?></h5>
	<?php endif; ?>
	</div>
	<div class="col-md-1">
		
			<?php do_action( 'wc_product_addon_options', $addon ); ?>
		
			<?php if ( $description ) : ?>
		<a style="border: 2px solid #777; height: 22px;font-size: 14px; float: left;
    font-weight: bold; padding:0; width: 25px; border-radius:50%; color:#777;" type="button" class="btn btn-default pull-right" data-toggle="tooltip" trigger="click hover focus" data-placement="right auto" title="<?php echo  $description; ?>">?</a>
		<?php endif; ?>
		
		
	</div>
</div>
	

	

	
