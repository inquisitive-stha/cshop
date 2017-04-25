<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       pragtechs.com
 * @since      1.0.0
 *
 * @package    Copyshop
 * @subpackage Copyshop/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Copyshop
 * @subpackage Copyshop/admin
 * @author     Pragmatic Technology <info@pragtechs.com>
 */
class Copyshop_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Copyshop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Copyshop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name."-admin", plugin_dir_url( __FILE__ ) . 'css/copyshop-admin.css', array(), $this->version, 'all' );
                
                wp_enqueue_style( $this->plugin_name."-bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
                wp_enqueue_style( $this->plugin_name."-bootstrap-dialog", plugin_dir_url( __FILE__ ) . 'css/bootstrap-dialog.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Copyshop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Copyshop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name."-adminjs", plugin_dir_url( __FILE__ ) . 'js/copyshop-admin.js', array( 'jquery' ), $this->version, false );
                wp_enqueue_script( $this->plugin_name."-bootstrapjs", plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
                wp_enqueue_script( $this->plugin_name."-bootstrapjs_dialog", plugin_dir_url( __FILE__ ) . 'js/bootstrap-dialog.min.js', array( 'jquery' ), $this->version, false );

	}
        
        public function admin_menu()
        {
            add_menu_page('CopyShop General Settings', 'CopyShop', 'manage_options', 'copyshop_main', 'copyshop_main');
            //add_submenu_page('copyshop_settings', 'Paper Format', 'Paper Format', 'manage_options', 'copyshop_paper_format', 'copyshop_paper_format');
            //add_submenu_page('copyshop_settings', 'Paper Weight', 'Paper Weight', 'manage_options', 'copyshop_paper_weight', 'copyshop_paper_weight');
//            add_submenu_page('copyshop_settings', 'Printing Costs', 'Printing Costs', 'manage_options', 'copyshop_printing_cost', 'copyshop_printing_cost');
//            add_submenu_page('copyshop_settings', 'Paper Costs', 'Paper Costs', 'manage_options', 'copyshop_paper_cost', 'copyshop_paper_cost');
//            add_submenu_page('copyshop_settings', 'Delivery Costs', 'Delivery Costs', 'manage_options', 'copyshop_delivery_cost', 'copyshop_delivery_cost');
//            add_submenu_page('copyshop_settings', 'Task', 'Task', 'manage_options', 'copyshop_task', 'copyshop_task');
//            add_submenu_page('copyshop_settings', 'Task Price', 'Task Price', 'manage_options', 'copyshop_task_price', 'copyshop_task_price');
//            add_submenu_page('copyshop_settings', 'Saroj', 'Saroj', 'manage_options', 'copyshop_main', 'copyshop_saroj');
            
            
            
        }
        
        public function adminajax()
        {
            add_action("wp_ajax_savesettings", "doSaveSettings");
            add_action("wp_ajax_deletesettings", "doDeleteSettings");
            
            add_action("wp_ajax_saveformat", "doSaveFormat");
            add_action("wp_ajax_deleteformat", "doDeleteFormat");
            
            add_action("wp_ajax_saveweight", "doSaveWeight");
            add_action("wp_ajax_deleteweight", "doDeleteWeight");
            
            add_action("wp_ajax_saveprcost", "doSavePrCost");
            add_action("wp_ajax_deleteprcost", "doDeletePrCost");
            
            add_action("wp_ajax_savepapercost", "doSavePaperCost");
            add_action("wp_ajax_deletepapercost", "doDeletePaperCost");
            
            add_action("wp_ajax_savedeliverycost", "doSaveDeliveryCost");
            add_action("wp_ajax_deletedeliverycost", "doDeleteDeliveryCost");
            
            add_action("wp_ajax_savetask", "doSaveTask");
            add_action("wp_ajax_deletetask", "doDeleteTask");
            
            add_action("wp_ajax_savetaskprice", "doSaveTaskPrice");
            add_action("wp_ajax_deletetaskprice", "doDeleteTaskPrice");
            
            add_action("wp_ajax_savesettings", "doSaveSettings");
            add_action("wp_ajax_deletesettings", "doDeleteSettings");
            
           // add_action("wp_ajax_nopriv_saveformat", "doSaveFormat");
            // add_action("wp_ajax_nopriv_deleteformat", "doSaveFormat");
        }

}
