<?php
/**
 * Plugin Name: Min and Max Quantity for WooCommerce
 * Plugin URI: http://berocket.com/product/woocommerce-minmax-quantity
 * Description: Plugin for WooCommerce which add minimum and maximum quantities for products
 * Version: 1.0.2
 * Author: BeRocket
 * Requires at least: 4.0
 * Author URI: http://berocket.com
 * Text Domain: BeRocket_MM_Quantity_domain
 * Domain Path: /languages/
 */
define( "BeRocket_MM_Quantity_version", '1.0.2' );
define( "BeRocket_MM_Quantity_domain", 'BeRocket_MM_Quantity_domain'); 
define( "MM_QUANTITY_TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . "templates/" );
load_plugin_textdomain('BeRocket_MM_Quantity_domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
require_once(plugin_dir_path( __FILE__ ).'includes/functions.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class BeRocket_MM_Quantity
 */
class BeRocket_MM_Quantity {

    public static $info = array( 
        'id'        => 9,
        'version'   => BeRocket_MM_Quantity_version,
        'plugin'    => '',
        'slug'      => '',
        'key'       => '',
        'name'      => ''
    );

    /**
     * Defaults values
     */
    public static $defaults = array(
        'hide_checkout'         => '',
        'checkout_class'        => '.checkout-button',
        'checkout_mini_class'   => '.checkout',
        'cart_min_price'        => '',
        'cart_max_price'        => '',
        'cart_min_quantity'     => '',
        'cart_max_quantity'     => '',
        'custom_css'            => '',
        'plugin_key'            => '',
    );
    
    function __construct () {
        register_uninstall_hook(__FILE__, array( __CLASS__, 'deactivation' ) );

        if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && 
            br_get_woocommerce_version() >= 2.1 ) {
            $options = BeRocket_MM_Quantity::get_mm_quantity_option();
            add_action ( 'init', array( __CLASS__, 'init' ) );
            add_action ( 'wp_head', array( __CLASS__, 'set_styles' ) );
            add_action ( 'admin_init', array( __CLASS__, 'register_mm_quantity_options' ) );
            add_action ( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
            add_action ( 'admin_menu', array( __CLASS__, 'mm_quantity_options' ) );
            add_action( "wp_ajax_br_mm_quantity_settings_save", array ( __CLASS__, 'save_settings' ) );
            
            add_action( 'woocommerce_product_options_general_product_data', array( __CLASS__, 'wc_product_field' ) );
            add_action( 'save_post', array( __CLASS__, 'wc_save_product' ) );
            add_action( 'woocommerce_product_after_variable_attributes', array( __CLASS__, 'variation_settings_fields' ), 10, 3 );
            add_action( 'woocommerce_save_product_variation', array( __CLASS__, 'save_variation_settings_fields' ), 10, 2 );
            add_action( 'woocommerce_after_calculate_totals', array( __CLASS__, 'cart_calculate_total' ) );
        }
    }
    /**
     * Function that use for WordPress init action
     *
     * @return void
     */
    public static function init () {
        $options = BeRocket_MM_Quantity::get_mm_quantity_option();
        wp_enqueue_script("jquery");
        wp_register_style( 'berocket_mm_quantity_style', plugins_url( 'css/shop.css', __FILE__ ), "", BeRocket_MM_Quantity_version );
        wp_enqueue_style( 'berocket_mm_quantity_style' );
        wp_register_style( 'font-awesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ) );
        wp_enqueue_style( 'font-awesome' );
    }

    public static function wc_product_field() {
        woocommerce_wp_text_input( 
            array( 
                'id' => 'min_quantity', 
                'class' => 'wc_input_stock short', 
                'label' => __( 'Minimum Quantity', 'BeRocket_MM_Quantity_domain' ), 
                'type' => 'number', 
                'custom_attributes' => array('min' => '1') 
            ) 
        );
        woocommerce_wp_text_input( 
            array( 
                'id' => 'max_quantity', 
                'class' => 'wc_input_stock short', 
                'label' => __( 'Maximum Quantity', 'BeRocket_MM_Quantity_domain' ), 
                'type' => 'number', 
                'custom_attributes' => array('min' => '1') 
            ) 
        );
        $options = BeRocket_MM_Quantity::get_mm_quantity_option();
        if( isset($options['groups']) && is_array($options['groups']) && count($options['groups']) > 0 ) {
            $option = array('' => ' ');
            foreach($options['groups'] as $g_num => $group) {
                if( isset($group['slug']) && $group['slug'] != '' ) {
                    $option[$group['slug']] = $group['name'];
                }
            }
            woocommerce_wp_select(
                array(
                    'id' => 'group_quantity',
                    'label' => __('Quantity Group', 'BeRocket_MM_Quantity_domain'),
                    'options' => $option
                )
            );
        }
    }
    public static function wc_save_product( $product_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( isset( $_POST['min_quantity'] ) ) {
            update_post_meta( $product_id, 'min_quantity', $_POST['min_quantity'] );
        } else {
            delete_post_meta( $product_id, 'min_quantity' );
        }
        if ( isset( $_POST['max_quantity'] ) ) {
            update_post_meta( $product_id, 'max_quantity', $_POST['max_quantity'] );
        } else {
            delete_post_meta( $product_id, 'max_quantity' );
        }
        if ( isset( $_POST['group_quantity'] ) ) {
            update_post_meta( $product_id, 'group_quantity', $_POST['group_quantity'] );
        } else {
            delete_post_meta( $product_id, 'group_quantity' );
        }
    }
    public static function variation_settings_fields( $loop, $variation_data, $variation ) {
        woocommerce_wp_text_input( 
            array( 
                'id'                => 'min_quantity_var[' . $variation->ID . ']', 
                'label'             => __( 'Minimum Quantity', 'BeRocket_MM_Quantity_domain' ), 
                'value'             => get_post_meta( $variation->ID, 'min_quantity_var', true ),
                'custom_attributes' => array('min' => '1')
            )
        );
        woocommerce_wp_text_input( 
            array( 
                'id'                => 'max_quantity_var[' . $variation->ID . ']', 
                'label'             => __( 'Maximum Quantity', 'BeRocket_MM_Quantity_domain' ), 
                'value'             => get_post_meta( $variation->ID, 'max_quantity_var', true ),
                'custom_attributes' => array('min' => '1')
            )
        );
        $options = BeRocket_MM_Quantity::get_mm_quantity_option();
        if( isset($options['groups']) && is_array($options['groups']) && count($options['groups']) > 0 ) {
            $option = array('' => ' ');
            foreach($options['groups'] as $g_num => $group) {
                if( isset($group['slug']) && $group['slug'] != '' ) {
                    $option[$group['slug']] = $group['name'];
                }
            }
            woocommerce_wp_select(
                array(
                    'id' => 'group_quantity_var[' . $variation->ID . ']',
                    'label' => __('Quantity Group', 'BeRocket_MM_Quantity_domain'),
                    'value' => get_post_meta( $variation->ID, 'group_quantity_var', true ),
                    'options' => $option
                )
            );
        }
    }
    public static function save_variation_settings_fields( $post_id ) {
        if( isset( $_POST['min_quantity_var'][ $post_id ] ) ) {
            update_post_meta( $post_id, 'min_quantity_var', $_POST['min_quantity_var'][ $post_id ] );
        }
        if( isset( $_POST['max_quantity_var'][ $post_id ] ) ) {
            update_post_meta( $post_id, 'max_quantity_var', $_POST['max_quantity_var'][ $post_id ] );
        }
        if( isset( $_POST['group_quantity_var'][ $post_id ] ) ) {
            update_post_meta( $post_id, 'group_quantity_var', $_POST['group_quantity_var'][ $post_id ] );
        }
    }
    public static function cart_calculate_total( $cart ) {
        $return_result = false;
        $product_qty_in_cart = $cart->get_cart_item_quantities();
        $max_error = __('Quantity of product %p% can not be more then <strong>%c%</strong>', 'BeRocket_MM_Quantity_domain');
        $min_error = __('Quantity of product %p% can not be less then <strong>%c%</strong>', 'BeRocket_MM_Quantity_domain');
        $max_error_var = __('Quantity of one variation of a %p% product can not be more then <strong>%c%</strong>', 'BeRocket_MM_Quantity_domain');
        $min_error_var = __('Quantity of one variation of a %p% product can not be less then <strong>%c%</strong>', 'BeRocket_MM_Quantity_domain');
        if ( wc_notice_count( 'error' ) == 0 ) {
            $return_result = true;
            $options = BeRocket_MM_Quantity::get_mm_quantity_option();
            $product_error = array();
            foreach ( $cart->get_cart() as $cart_item_key => $values ) {
                $_product = $values['data'];
                $group_quantity = '';
                if ( ! in_array( $values['product_id'], $product_error ) ) {
                    $min_quantity = get_post_meta( $values['product_id'], 'min_quantity', true );
                    $max_quantity = get_post_meta( $values['product_id'], 'max_quantity', true );
                    $qty_prod = $product_qty_in_cart[ $values['product_id'] ];
                    if( isset($min_quantity) && is_numeric($min_quantity) && $min_quantity > $qty_prod ) {
                        $min_error_p = str_replace( '%p%', $_product->post->post_title, $min_error);
                        $min_error_p = str_replace( '%c%', $min_quantity, $min_error_p);
                        wc_add_notice( $min_error_p, 'error' );
                    }
                    if( isset($max_quantity) && is_numeric($max_quantity) && $max_quantity < $qty_prod ) {
                        $max_error_p = str_replace( '%p%', $_product->post->post_title, $max_error);
                        $max_error_p = str_replace( '%c%', $max_quantity, $max_error_p);
                        $return_result = false;
                        wc_add_notice( $max_error_p, 'error' );
                    }
                    $product_error[] = $values['product_id'];
                }
                if ( $_product->is_type( 'variation' ) ) {
                    $qty_variation = $values['quantity'];
                    $min_quantity_var = get_post_meta( $values['variation_id'], 'min_quantity_var', true );
                    $max_quantity_var = get_post_meta( $values['variation_id'], 'max_quantity_var', true );
                    if( isset($min_quantity_var) && is_numeric($min_quantity_var) && $min_quantity_var > $qty_variation ) {
                        $min_error_p = str_replace( '%p%', $_product->post->post_title, $min_error_var);
                        $min_error_p = str_replace( '%c%', $min_quantity_var, $min_error_p);
                        wc_add_notice( $min_error_p, 'error' );
                    }
                    if( isset($max_quantity_var) && is_numeric($max_quantity_var) && $max_quantity_var < $qty_variation ) {
                        $max_error_p = str_replace( '%p%', $_product->post->post_title, $max_error_var);
                        $max_error_p = str_replace( '%c%', $max_quantity_var, $max_error_p);
                        $return_result = false;
                        wc_add_notice( $max_error_p, 'error' );
                    }
                }
            }
            if( count( $cart->get_cart() ) > 0 ) {
                $cart_total = $cart->cart_contents_total;
                $cart_count = $cart->cart_contents_count;
                $options = BeRocket_MM_Quantity::get_mm_quantity_option();
                if( is_numeric($options['cart_min_price']) ) {
                    $min_price = $options['cart_min_price'];
                    $min_price = apply_filters('woocommerce_get_price', $min_price, false);
                    $min_html = wc_price( $min_price );
                    $cart_cost_more = __('Total cost of products in cart must be <strong>%c%</strong> or more', 'BeRocket_MM_Quantity_domain');
                    $cart_cost_more = str_replace( '%c%', $min_html, $cart_cost_more);
                    if ( $min_price > $cart_total ) {
                        wc_add_notice( $cart_cost_more, 'error' );
                    }
                }
                if( is_numeric($options['cart_max_price']) ) {
                    $max_price = $options['cart_max_price'];
                    $max_price = apply_filters('woocommerce_get_price', $max_price, false);
                    $max_html = wc_price( $max_price );
                    $cart_cost_less = __('Total cost of products in cart must be <strong>%c%</strong> or less', 'BeRocket_MM_Quantity_domain');
                    $cart_cost_less = str_replace( '%c%', $max_html, $cart_cost_less);
                    if ( $max_price < $cart_total ) {
                        $return_result = false;
                        wc_add_notice( $cart_cost_less, 'error' );
                    }
                }
                if( is_numeric($options['cart_min_quantity']) ) {
                    $cart_quantity_more = __('Quantity of products in cart must be <strong>%c%</strong> or more', 'BeRocket_MM_Quantity_domain');
                    $cart_quantity_more = str_replace( '%c%', $options['cart_min_quantity'], $cart_quantity_more);
                    if ( $options['cart_min_quantity'] > $cart_count ) {
                        wc_add_notice( $cart_quantity_more, 'error' );
                    }
                }
                if( is_numeric($options['cart_max_quantity']) ) {
                    $cart_quantity_less = __('Quantity of products in cart must be <strong>%c%</strong> or less', 'BeRocket_MM_Quantity_domain');
                    $cart_quantity_less = str_replace( '%c%', $options['cart_max_quantity'], $cart_quantity_less);
                    if ( $options['cart_max_quantity'] < $cart_count ) {
                        $return_result = false;
                        wc_add_notice( $cart_quantity_less, 'error' );
                    }
                }
            }
        }
        if( $return_result === false ) {
            self::hide_checkout_button();
        }
    }
    public static function hide_checkout_button() {
        $options = BeRocket_MM_Quantity::get_mm_quantity_option();
        if( $options['hide_checkout'] ) {
            add_action( 'woocommerce_after_cart_table', array(__CLASS__, 'wp_footer_hide') );
            add_action( 'woocommerce_after_mini_cart', array(__CLASS__, 'wp_footer_hide') );
        }
    }
    public static function wp_footer_hide() {
        $options = BeRocket_MM_Quantity::get_mm_quantity_option();
        echo '<style>
        ', $options['checkout_class'], '{display:none!important;}
        ', $options['checkout_mini_class'], '{display:none!important;}
        </style>';
    }

    /**
     * Function set styles in wp_head WordPress action
     *
     * @return void
     */
    public static function set_styles () {
        $options = BeRocket_MM_Quantity::get_mm_quantity_option();
        echo '<style>'.$options['custom_css'].'</style>';
    }
    /**
     * Load template
     *
     * @access public
     *
     * @param string $name template name
     *
     * @return void
     */
    public static function br_get_template_part( $name = '' ) {
        $template = '';

        // Look in your_child_theme/woocommerce-list-grid/name.php
        if ( $name ) {
            $template = locate_template( "woocommerce-minmax-quantity/{$name}.php" );
        }

        // Get default slug-name.php
        if ( ! $template && $name && file_exists( MM_QUANTITY_TEMPLATE_PATH . "{$name}.php" ) ) {
            $template = MM_QUANTITY_TEMPLATE_PATH . "{$name}.php";
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'mm_quantity_get_template_part', $template, $name );

        if ( $template ) {
            load_template( $template, false );
        }
    }

    public static function admin_enqueue_scripts() {
        if ( function_exists( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        } else {
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );
        }
    }

    /**
     * Function adding styles/scripts and settings to admin_init WordPress action
     *
     * @access public
     *
     * @return void
     */
    public static function register_mm_quantity_options () {
        wp_enqueue_script( 'berocket_aapf_widget-colorpicker', plugins_url( 'js/colpick.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'berocket_mm_quantity_admin', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), BeRocket_MM_Quantity_version );
        wp_register_style( 'berocket_aapf_widget-colorpicker-style', plugins_url( 'css/colpick.css', __FILE__ ) );
        wp_enqueue_style( 'berocket_aapf_widget-colorpicker-style' );
        wp_register_style( 'berocket_mm_quantity_admin_style', plugins_url( 'css/admin.css', __FILE__ ), "", BeRocket_MM_Quantity_version );
        wp_enqueue_style( 'berocket_mm_quantity_admin_style' );
        register_setting('br_mm_quantity_option', 'br_mm_quantity_option', array( __CLASS__, 'sanitize_mm_quantity_option' ));
        add_settings_section( 
            'br_mm_quantity_option',
            'Currency Exchange Settings',
            'br_mm_quantity_option_callback',
            'br_mm_quantity_option'
        );
    }
    /**
     * Function add options button to admin panel
     *
     * @access public
     *
     * @return void
     */
    public static function mm_quantity_options() {
        add_submenu_page( 'woocommerce', __('Min/Max Quantity settings', 'BeRocket_MM_Quantity_domain'), __('Min/Max Quantity', 'BeRocket_MM_Quantity_domain'), 'manage_options', 'br-mm-quantity', array(
            __CLASS__,
            'mm_quantity_option_form'
        ) );
    }
    /**
     * Function add options form to settings page
     *
     * @access public
     *
     * @return void
     */
    public static function mm_quantity_option_form() {
        include MM_QUANTITY_TEMPLATE_PATH . "settings.php";
    }
    /**
     * Function remove settings from database
     *
     * @return void
     */
    public static function deactivation () {
        delete_option( 'br_mm_quantity_options' );
    }

    public static function open_exchange_load () {
        self::get_open_exchange(true);
        wp_die();
    }
    public static function save_settings () {
        if( current_user_can( 'manage_options' ) ) {
            if( isset($_POST['br_mm_quantity_options']) ) {
                if( isset($_POST['br_mm_quantity_options']['groups']) && is_array($_POST['br_mm_quantity_options']['groups']) ) {
                    foreach($_POST['br_mm_quantity_options']['groups'] as $i => $group_data) {
                        $group_data['slug'] = sanitize_title($group_data['name']);
                        $group_data['slug'] = sanitize_title_with_dashes($group_data['slug']);
                        $_POST['br_mm_quantity_options']['groups'][$i] = $group_data;
                    }
                }
                update_option( 'br_mm_quantity_options', self::sanitize_mm_quantity_option($_POST['br_mm_quantity_options']) );
                echo json_encode($_POST['br_mm_quantity_options']);
            }
        }
        wp_die();
    }

    public static function sanitize_mm_quantity_option( $input ) {
        $default = BeRocket_MM_Quantity::$defaults;
        $result = self::recursive_array_set( $default, $input );
        return $result;
    }
    public static function recursive_array_set( $default, $options ) {
        $result = array();
        foreach( $default as $key => $value ) {
            if( array_key_exists( $key, $options ) ) {
                if( is_array( $value ) ) {
                    if( is_array( $options[$key] ) ) {
                        $result[$key] = self::recursive_array_set( $value, $options[$key] );
                    } else {
                        $result[$key] = self::recursive_array_set( $value, array() );
                    }
                } else {
                    $result[$key] = $options[$key];
                }
            } else {
                if( is_array( $value ) ) {
                    $result[$key] = self::recursive_array_set( $value, array() );
                } else {
                    $result[$key] = '';
                }
            }
        }
        foreach( $options as $key => $value ) {
            if( ! array_key_exists( $key, $result ) ) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    public static function get_mm_quantity_option() {
        $options = get_option( 'br_mm_quantity_options' );
        if ( @ $options && is_array ( $options ) ) {
            $options = array_merge( BeRocket_MM_Quantity::$defaults, $options );
        } else {
            $options = BeRocket_MM_Quantity::$defaults;
        }
        return $options;
    }
}

new BeRocket_MM_Quantity;