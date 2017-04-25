<?php
/**
 * Copyshop FFM functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage CopyshopFFM
 * @since Copyshop FFM 1.0
 */
require_once get_template_directory().'/inc/cleanup.php';
/**
 * Customize the title for the home page, if one is not set.
 *
 * @param string $title The original title.
 * @return string The title to use.
 */
function wpdocs_hack_wp_title_for_home( $title )
{
  if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
    $title = __( 'Home', 'textdomain' ) . ' | ' . get_bloginfo( 'title' );
  }
  return $title;
}
add_filter( 'wp_title', 'wpdocs_hack_wp_title_for_home' );
/**
 * Provides a standard format for the page title depending on the view. This is
 * filtered so that plugins can provide alternative title formats.
 *
 * @param       string    $title    Default title text for current view.
 * @param       string    $sep      Optional separator.
 * @return      string              The filtered title.
 * @package     copyshop
 * @subpackage  includes
 * @version     1.0.0
 * @since       1.0.0
 */
function copyshop_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) {
		return $title;
	} // end if
	// Add the site name.
	$title .= get_bloginfo( 'name' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	} // end if
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = sprintf( __( 'Page %s', 'copyshop' ), max( $paged, $page ) ) . " $sep $title";
	} // end if
	return $title;
} // end copyshop_wp_title
add_filter( 'wp_title', 'copyshop_wp_title', 10, 2 );

/*custom excerpt length
my_excerpt(); // just a regular WordPress excerpt (55 words)
my_excerpt(30); // 30 words with formatting (<p>this is an excerpt ... [...]</p>)
get_my_excerpt(30); // 30 words without formatting (this is an excerpt ... [...])

// outside the loop
// pass a Post ID to the function (required outside the loop)

my_excerpt(30, 22); // 30 word excerpt of Post with ID 22
get_my_excerpt(30, 22); // 30 word excerpt of Post with ID 22
*/
function my_excerpt($excerpt_length = 55, $id = false, $echo = true) {
	  
    $text = '';
    
	  if($id) {
	  	$the_post = & get_post( $my_id = $id );
	  	$text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
	  } else {
	  	global $post;
	  	$text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
    }
	  
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
	  $text = strip_tags($text);
	
		$excerpt_more = ' ' . '...';
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	if($echo)
  echo apply_filters('the_content', $text);
	else
	return $text;
}

function get_my_excerpt($excerpt_length = 55, $id = false, $echo = false) {
 return my_excerpt($excerpt_length, $id, $echo);
}
/*add styles and scripts*/
function copyshop_scripts() {
	wp_enqueue_style( 'bootstrap.min', get_template_directory_uri().'/css/bootstrap.css');
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.css');
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri().'/css/owl.carousel.css');
	wp_enqueue_style( 'owl.theme', get_template_directory_uri().'/css/owl.theme.css');
	/*wp_enqueue_style('style',get_stylesheet_uri(),array(), rand(111,9999), 'all');*/
	wp_enqueue_style('style',get_stylesheet_uri());
	wp_enqueue_style( 'responsive', get_template_directory_uri().'/css/responsive.css');
	wp_enqueue_style( 'sm-blue', get_template_directory_uri().'/css/sm-blue.css');

	

}
add_action( 'wp_enqueue_scripts', 'copyshop_scripts' );
/*remove product adons script and load custom script*/
add_action('wp_enqueue_scripts', 'wpse26822_script_fix', 100);
function wpse26822_script_fix()
{
    


   
}

/**
 * copyshop engine room
 *
 * @package copyshop
 */

/**
 * Initialize all the things.
 */
//require get_stylesheet_directory() . '/inc/init.php';
if ( ! function_exists( 'onsale_product_search' ) ) {
	/**
	 * Display Site Branding
	 * @since  1.0.0
	 * @return void
	 */
	function onsale_product_search() {
		$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div>
			<label class="screen-reader-text" for="s">' . __( 'Search for:', 'onsale' ) . '</label>
			<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'type search query and enter...', 'onsale' ) . '" />
			<button type="submit" id="searchsubmit"><span class="fa fa-search"></span></button>
			<input type="hidden" name="post_type" value="product" />
		</div>
		</form>';
		
		echo $form;
	}
}
/*custom logo support*/
function theme_prefix_setup() {
    
    add_theme_support( 'custom-logo', array(
   'height'      => 175,
   'width'       => 400,
   'flex-width' => true,
   'flex-height' => true,
	) );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'theme_prefix_setup' );

function copyshop_the_custom_logo() {
   if ( function_exists( 'the_custom_logo' ) ) {
      the_custom_logo();
   }
}
/*copyshop cart*/

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?>&nbsp;<i class="fa fa-shopping-cart"></i></a> 
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

/*remove product image on product single page*/
add_action( 'init' , 'mh_add_and_remove' , 55 );
function mh_add_and_remove() {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
}

/*check the post type*/
function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}
/**
*@package Copyshop Product slider custom post type
*@see  Owl Product slider
*@since Copyshop FFM 1.0
**/

// Custom Post types for Feature project on home page
add_action('init', 'create_feature');
 function create_feature() {
   $feature_args = array(
      'labels' => array(
       'name' => __( 'Product Slider' ),
       'singular_name' => __( 'slide' ),
       'all_items'           => __( 'All Slides', 'text_domain' ),
       'add_new' => __( 'Add New slide' ),
       'add_new_item' => __( 'Add New slide' ),
       'edit_item' => __( 'Edit slide' ),
       'new_item' => __( 'Add New slide' ),
       'view_item' => __( 'View slide' ),
       'search_items' => __( 'Search slide' ),
       'not_found' => __( 'No slide found' ),
       'not_found_in_trash' => __( 'No slide found in trash' )
     ),
   'taxonomies' => array('category'), 
   'public' => true,
   'show_ui' => true,
   'capability_type' => 'post',
   'hierarchical' => false,
   'rewrite' => true,
   'menu_position' => 20,
   'menu_icon'     => 'dashicons-images-alt2',
   'supports' => array('title', 'editor', 'thumbnail','custom-fields')
 );
register_post_type('product-slider',$feature_args);
}
require get_stylesheet_directory() . '/inc/pricebeforecart.php';