<?php
/*
Plugin Name: WPHobby WooCommerce Product Filter
Plugin URI: https://wphobby.com/downloads/wphobby-woocommerce-product-filter/
Description: Add Product Filter on your WooCommerce Website.
Version: 1.0.0
Author: wphobby
Author URI: http://wphobby.com
*/

if ( ! defined( 'ABSPATH' ) ) {
   exit;
} // Exit if accessed directly

// Load plugin text domian
load_plugin_textdomain( 'woo-product-filter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// Set constants
define('WHPF_DIR', plugin_dir_path(__FILE__));
define('WHPF_URL', plugin_dir_url(__FILE__));
define('WHPF_OPTIONS', 'whpf_general_data');
define('WHPF_VERSION', '1.0.0');

if( ! function_exists( 'whpf_install_woocommerce_admin_notice' ) ) {
   /**
    * Display an admin notice if woocommerce is deactivated
    *
    * @since 1.0.0
    * @return void
    * @use admin_notices hooks
    */
   function whpf_install_woocommerce_admin_notice() { ?>
      <div class="error">
         <p><?php _e( 'WooCommerce Ajax Product Filter is enabled but not effective. It requires WooCommerce in order to work.', 'woo-product-filter' ); ?></p>
      </div>
      <?php
   }
}

if( ! function_exists( 'whpf_install' ) ){
   function whpf_install() {

      if ( ! function_exists( 'WC' ) ) {
         add_action( 'admin_notices', 'whpf_install_woocommerce_admin_notice' );
      }else{
         // Include files
         require_once('includes/whpf_init.php');
         require_once('includes/whpf_tools.php');
         require_once('includes/whpf_admin.php');
         require_once('widgets/whpf_navigation_widget.php');
         require_once('widgets/whpf_reset_widget.php');

         // Initalize this plugin
         $WHPF = new WHPF();
         // When admin active this plugin
         register_activation_hook(__FILE__, array(&$WHPF, 'activate'));
         // When admin deactive this plugin
         register_deactivation_hook(__FILE__, array(&$WHPF, 'deactivate'));

         // Run the plugins initialization method
         add_action('init', array(&$WHPF, 'initialize'));

      }
   }
}

add_action( 'plugins_loaded', 'whpf_install', 11 );
?>