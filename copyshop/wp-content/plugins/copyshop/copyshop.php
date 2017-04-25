<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              pragtechs.com
 * @since             1.0.0
 * @package           Copyshop
 *
 * @wordpress-plugin
 * Plugin Name:       CopyShop
 * Plugin URI:        pragtechs.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pragmatic Technology
 * Author URI:        pragtechs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       copyshop
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
include_once('commmons.php');
include_once('router.php');
include_once('ajax.php');


define('COPYSHOP_ROOT',  plugin_dir_path( __FILE__ ));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-copyshop-activator.php
 */
function activate_copyshop() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-copyshop-activator.php';
	Copyshop_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-copyshop-deactivator.php
 */
function deactivate_copyshop() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-copyshop-deactivator.php';
	Copyshop_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_copyshop' );
register_deactivation_hook( __FILE__, 'deactivate_copyshop' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-copyshop.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_copyshop() {

	$plugin = new Copyshop();
	$plugin->run();

}
run_copyshop();
