<?php
/*
Plugin Name: SP Woocommerce Outfits
Plugin URI: https://screenpartner.no/
Description: SP Woocommerce Outfits allows you to create outfits linked to your WooCommerce products
Version: 1.0.0
Author: Michael Wilhelmsen
Author URI: https://profiles.wordpress.org/michaelw90
Text Domain: sp-woocommerce-outfits
Domain Path: /lang
*/

namespace SP_Woocommerce_Outfits;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//plugin constants
define( 'SPWO_PLUGIN', plugins_url( '', __FILE__ ) );
define( 'SPWO_PLUGIN_PATH', plugin_basename( dirname( __FILE__ ) ) );
define( 'SPWO_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'SPWO_PLUGIN_VERSION', '1.0.0' );

//clean brands slug on plugin deactivation
register_deactivation_hook( __FILE__, function(){
  update_option( 'old_wc_spwo_admin_tab_slug', 'null' );
} );

//loads textdomain for the translations
add_action( 'plugins_loaded', function(){
  load_plugin_textdomain( 'sp-woocommerce-outfits', false, SPWO_PLUGIN_PATH . '/lang' );
} );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if( is_plugin_active( 'woocommerce/woocommerce.php' ) ){

  if ( file_exists( dirname( __FILE__ ) . '/metaboxes/cmb2/init.php' ) ) {
  	require_once dirname( __FILE__ ) . '/metaboxes/cmb2/init.php';
    require_once(plugin_dir_path( __FILE__ ) . 'metaboxes/cmb-field-select2-master/cmb-field-select2.php');
  } elseif ( file_exists( dirname( __FILE__ ) . '/metaboxes/CMB2/init.php' ) ) {
  	require_once dirname( __FILE__ ) . '/metaboxes/CMB2/init.php';
    require_once(plugin_dir_path( __FILE__ ) . 'metaboxes/cmb-field-select2-master/cmb-field-select2.php');
  }

  require_once 'outfits/post-type.php';
  require 'classes/class-sp-woocommerce-outfits.php';

  new \SP_Woocommerce_Outfits\SP_Woocommerce_Outfits();

}elseif( is_admin() ){

  add_action( 'admin_notices', function() {
      $message = __( 'SP Woocommerce Outfits needs WooCommerce to run. Please, install and activate WooCommerce plugin.', 'sp-woocommerce-outfits' );
      printf( '<div class="%1$s"><p>%2$s</p></div>', 'notice notice-error', $message );
  });

}
