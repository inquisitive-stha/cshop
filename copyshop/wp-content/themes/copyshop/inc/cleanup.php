<?php
/**
*@package copyshop theme
*	======================================
*		REMOVE GEERATOR VERSION NUMBER
*	======================================
*/

/* Remove Version string From CSS and js*/

function copyshop_remove_wp_version_strigs( $src ){
	global $wp_version;
	parse_str( parse_url( $src, PHP_URL_QUERY ), $query );
	if ( !empty($query['ver']) && ($query['ver']=== $wp_version)  ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'copyshop_remove_wp_version_strigs' );
add_filter( 'style_loader_src', 'copyshop_remove_wp_version_strigs' );

/* Remove MetaTag generator from header */
function copyshop_remove_meta_version(){
	return '';
}
add_filter( 'the_generator', 'copyshop_remove_meta_version' );
