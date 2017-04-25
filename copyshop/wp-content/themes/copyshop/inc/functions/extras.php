<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package copyshop
 */

/**
 * Check whether the Storefront Customizer settings ar enabled
 * @return boolean
 * @since  1.1.2
 */
function is_copyshop_customizer_enabled() {
	return apply_filters( 'copyshop_customizer_enabled', true );
}


remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

/* social icons*/
function copyshop_social_icons()  { 

	$social_networks = array( 
	array( 'name' => __('Facebook','copyshop'), 'theme_mode' => 'copyshop_facebook','icon' => 'fa-facebook' ),
	array( 'name' => __('Twitter','copyshop'), 'theme_mode' => 'copyshop_twitter','icon' => 'fa-twitter' ),
	array( 'name' => __('Google+','copyshop'), 'theme_mode' => 'copyshop_google','icon' => 'fa-google-plus' ),
	array( 'name' => __('Pinterest','copyshop'), 'theme_mode' => 'copyshop_pinterest','icon' => 'fa-pinterest' ),
	array( 'name' => __('Linkedin','copyshop'), 'theme_mode' => 'copyshop_linkedin','icon' => 'fa-linkedin' ),
	array( 'name' => __('Youtube','copyshop'), 'theme_mode' => 'copyshop_youtube','icon' => 'fa-youtube' ),
	array( 'name' => __('Tumblr','copyshop'), 'theme_mode' => 'copyshop_tumblr','icon' => 'fa-tumblr' ),
	array( 'name' => __('Instagram','copyshop'), 'theme_mode' => 'copyshop_instagram','icon' => 'fa-instagram' ),
	array( 'name' => __('Flickr','copyshop'), 'theme_mode' => 'copyshop_flickr','icon' => 'fa-flickr' ),
	array( 'name' => __('Vimeo','copyshop'), 'theme_mode' => 'copyshop_vimeo','icon' => 'fa-vimeo-square' ),
	array( 'name' => __('RSS','copyshop'), 'theme_mode' => 'copyshop_rss','icon' => 'fa-rss' )
	);


	for ($row = 0; $row < 11; $row++){
		if (get_theme_mod( $social_networks[$row]["theme_mode"])): ?>
			<a href="<?php echo esc_url( get_theme_mod($social_networks[$row]['theme_mode']) ); ?>" class="social-tw" title="<?php echo esc_url( get_theme_mod( $social_networks[$row]['theme_mode'] ) ); ?>" target="_blank">
			<span class="fa <?php echo $social_networks[$row]['icon']; ?>"></span> 
			</a>
		<?php endif;
	}
										
}

function copyshop_check_number( $value ) {
		$value = (int) $value; // Force the value into integer type.
		return ( 0 < $value ) ? $value : null;
}