<?php
/**
 * Plugin Name: SOFORT Banking for WooCommerce
 * Plugin URI:  https://marketpress.com/product/woocommerce-sofort-banking/
 * Description: Integrates SOFORT Banking (SOFORT Überweisung) from sofort.com into your WooCommerce store.
 * Author: Awesome UG & MarketPress
 * Version: 1.1.18
 * Author URI: http://awesome.ug
 * Text Domain: woogate
 * Domain Path: /languages/
 *
 * Copyright 2016 (very@awesome.ug)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// No direct access is allowed
if( !defined( 'ABSPATH' ) )
	exit;

if( !class_exists( 'WooCommerce_SofortGateway' ) ) :
	/**
	 * Main class
	 *
	 * @since 1.0.0
	 */
	class WooCommerce_SofortGateway
	{
		/**
		 * The plugin version
		 */
		const VERSION = '1.0';

		/**
		 * Minimum required WP version
		 */
		const MIN_WP = '3.3.1';

		/**
		 * Minimum required Woocommerce version
		 */
		const MIN_WOO = '1.3.2.1';

		/**
		 * Minimum required PHP version
		 */
		const MIN_PHP = '5.2.4';

		/**
		 * Name of the plugin folder
		 */
		static private $plugin_name;

		/**
		 * Can the plugin be executed
		 */
		static private $active = FALSE;

		/**
		 * Supported currencies
		 */
		public static $supported_currencies;

		/**
		 * Initializing Plugin
		 *
		 * @since 1.0.0
		 * @access public
		 * @uses plugin_basename()
		 * @uses register_activation_hook()
		 * @uses register_uninstall_hook()
		 * @uses add_action()
		 */
		public function __construct()
		{
			self::$plugin_name = plugin_basename( __FILE__ );
			self::$supported_currencies = 'CHF,EUR,GBP,HUF,PLN';

			add_action( 'plugins_loaded', array( &$this, 'constants' ), 0 );
			add_action( 'plugins_loaded', array( &$this, 'translate' ), 0 );
			add_action( 'plugins_loaded', array( &$this, 'check_requirements' ), 0 );
			add_action( 'plugins_loaded', array( &$this, 'load' ), 1 );

			add_filter( 'plugin_row_meta', array( &$this, 'add_links' ), 10, 2 );

			if ( is_admin() ) {
				// require Auto Updater
				require_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'core/mp_auto_update.php';
				$plugindata_import = get_file_data(
					__FILE__,
					array(
						'plugin_uri' => 'Plugin URI',
						'plugin_name' => 'Plugin Name',
						'version' => 'Version'
					)
				);
				$plugin_data = new stdClass();
				$plugin_data->plugin_slug		= 'woocommerce-sofort-banking';
				$plugin_data->shortcode			= 'wcsofort';
				$plugin_data->plugin_name		= $plugindata_import[ 'plugin_name' ];
				$plugin_data->plugin_base_name	= plugin_basename( __FILE__ );
				$plugin_data->plugin_url		= $plugindata_import[ 'plugin_uri' ];
				$plugin_data->version			= $plugindata_import[ 'version' ];
				$autoupdate = MP_Sofort_Auto_Update::get_instance();
				$autoupdate->setup( $plugin_data );
			}
		}

		/**
		 * Load the core files
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function load()
		{
			if( self::$active === FALSE )
			{
				return FALSE;
			}

			// core files
			require( WOOGATE_ABSPATH . 'core/woogate-core.php' );
		}

		/**
		 * Declare all constants
		 *
		 * @since 1.0.0
		 * @access public
		 * @uses plugin_basename()
		 * @uses trailingslashit()
		 * @uses plugins_url()
		 */
		public function constants()
		{
			define( 'WOOGATE_PLUGIN', self::$plugin_name );
			define( 'WOOGATE_VERSION', self::VERSION );
			define( 'WOOGATE_ABSPATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			define( 'WOOGATE_URLPATH', trailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		}

		/**
		 * Load the languages
		 *
		 * @since 1.0.0
		 * @access public
		 * @uses load_plugin_textdomain()
		 */
		public function translate()
		{
			load_plugin_textdomain( 'woogate', FALSE, dirname( self::$plugin_name ) . '/languages/' );
		}

		/**
		 * Check for required versions
		 *
		 * Checks for WP, PHP and Woocommerce versions
		 *
		 * @since 1.0.0
		 * @access private
		 * @global string $wp_version Current WordPress version
		 */
		public function check_requirements()
		{
			global $wp_version;

			$error = FALSE;

			// Woocommerce checks
			if( !defined( 'WOOCOMMERCE_VERSION' ) )
			{
				add_action( 'admin_notices', create_function( '', 'printf( WooCommerce_SofortGateway::messages( "no_woo" ), admin_url( "plugin-install.php" ) );' ) );
				$error = TRUE;
			}
			elseif( version_compare( WOOCOMMERCE_VERSION, self::MIN_WOO, '>=' ) == FALSE )
			{
				add_action( 'admin_notices', create_function( '', 'printf( WooCommerce_SofortGateway::messages( "min_woo" ), Woocommerce_SofortGateway::MIN_WOO, admin_url( "update-core.php" ) );' ) );
				$error = TRUE;
			}

			// WordPress check
			if( version_compare( $wp_version, self::MIN_WP, '>=' ) == FALSE )
			{
				add_action( 'admin_notices', create_function( '', 'printf( WooCommerce_SofortGateway::messages( "min_wp" ), Woocommerce_SofortGateway::MIN_WP, admin_url( "update-core.php" ) );' ) );
				$error = TRUE;
			}

			// PHP check
			if( version_compare( PHP_VERSION, self::MIN_PHP, '>=' ) == FALSE )
			{
				add_action( 'admin_notices', create_function( '', 'printf( WooCommerce_SofortGateway::messages( "min_php" ), Woocommerce_SofortGateway::MIN_PHP );' ) );
				$error = TRUE;
			}

			// Currency check
			if( function_exists( 'get_woocommerce_currency' ) && self::check_currencies() !== TRUE )
			{
				add_action( 'admin_notices', create_function( '', 'printf( WooCommerce_SofortGateway::messages( "cur_fail" ), implode( ", ", WooCommerce_SofortGateway::check_currencies() ) );' ) );
			}

			self::$active = ( !$error ) ? TRUE : FALSE;
		}

		/**
		 * Checks the allowed Currencies
		 *
		 * @since 1.0.0
		 *
		 * @return array|bool
		 */
		public static function check_currencies()
		{
			// Currencies Check
			$currencies = apply_filters( 'wc_aelia_cs_enabled_currencies', array( get_woocommerce_currency() ) );

			$page = '';
			if( array_key_exists( 'page', $_GET ) )
			{
				$page = $_GET[ 'page' ];
			}

			$tab = '';
			if( array_key_exists( 'tab', $_GET ) )
			{
				$tab = $_GET[ 'tab' ];
			}

			$section = '';
			if( array_key_exists( 'section', $_GET ) )
			{
				$section = $_GET[ 'section' ];
			}

			// If page should noz show a message, interrupt the check and gibe back true
			if( ( $page != 'wc-settings' || $tab != 'checkout' || $section != 'woocommerce_sofortueberweisung' ) && $page != 'aelia_cs_options_page' )
				return TRUE;

			$supported_currencies = explode( ',', self::$supported_currencies );
			$failed_currencies = array();

			if( is_array( $currencies ) )
			{
				foreach( $currencies AS $currency )
				{
					if( !in_array( $currency, $supported_currencies ) )
						$failed_currencies[] = $currency;
				}
			}

			if( count( $failed_currencies ) === 0 )
				return TRUE;
			else return $failed_currencies;
		}

		/**
		 * Hold all error messages
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @param $key string Error/success key
		 * @param $type string Either 'error' or 'updated'
		 *
		 * @return string Error/success message
		 */
		public static function messages( $key = 'undefined', $type = 'error' )
		{
			$messages = array(
				'no_woo'   => __( 'WooCommerce SOFORT Banking requires WooCommerce to be installed. <a href="%s">Download it now</a>!', 'woogate' ),
				'min_woo'  => __( 'WooCommerce SOFORT Banking requires WooCommerce %s or higher. <a href="%s">Upgrade now</a>!', 'woogate' ),
				'min_wp'   => __( 'WooCommerce SOFORT Banking requires WordPress %s or higher. <a href="%s">Upgrade now</a>!', 'woogate' ),
				'min_php'  => __( 'WooCommerce SOFORT Banking requires PHP %s or higher. Please ask your hosting company for support.', 'woogate' ),
				'cur_fail' => __( 'WooCommerce SOFORT Banking does not support the currency/currencies: %s.', 'woogate' ),
			);

			return '<div id="message" class="' . $type . '"><p>' . $messages[ $key ] . '</p></div>';
		}

		/**
		 * Add links to the plugin screen
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function add_links( $links, $file )
		{
			if( $file == self::$plugin_name )
			{
				$links[] = '<a href="' . admin_url( '/admin.php?page=wc-settings&tab=checkout&section=woocommerce_sofortueberweisung' ) . '">' . __( 'Options', 'woogate' ) . '</a>';
			}

			return $links;
		}
	}

	$woogate = new WooCommerce_SofortGateway();
endif;