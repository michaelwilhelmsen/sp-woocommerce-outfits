<?php
namespace SP_Woocommerce_Outfits;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class SP_Woocommerce_Outfits {

  // Construct Plugin
  function __construct(){
    add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

    if ( !is_admin() ) {
      add_action( 'init', array( $this, 'register_frontend_scripts' ) );
    }

    // INCLUDE THE METABOXES
    add_action( 'cmb2_admin_init', array( $this, 'spwo_outfit_metabox' ) );

    // Include shortcodes
    $this->add_shortcodes();
  }

  // Admin Scripts
  public function register_admin_scripts(){
    wp_register_script('outfit-admin-js', plugins_url('sp-woocommerce-outfits/admin/js/outfit-functionality.js'), array('jquery'), SPWO_PLUGIN_VERSION, false);

    wp_enqueue_style('outfit-admin-css', plugins_url('sp-woocommerce-outfits/admin/css/outfit-functionality.css'), SPWO_PLUGIN_VERSION);
    wp_enqueue_script('outfit-admin-js');
  }

  // Admin Scripts
  public function register_frontend_scripts(){

  }

  public function spwo_outfit_metabox() {

    // set the prefix (start with an underscore to hide it from the custom fields list
    $prefix = '_spwo_';

    // create the metabox
    $cmb = new_cmb2_box( array(
        'id'            => 'spwo_outfit_metabox',
        'title'         => 'Outfit',
        'object_types'  => array( 'outfits' ), // post type
        'context'       => 'normal', // 'normal', 'advanced' or 'side'
        'priority'      => 'high', // 'high', 'core', 'default' or 'low'
        'show_names'    => true, // show field names on the left
        'cmb_styles'    => true, // false to disable the CMB stylesheet
        'closed'        => false, // keep the metabox closed by default
    ) );

    // file uploader
    $cmb->add_field( array(
        'name'    => 'Outfit Image',
        'desc'    => __('Upload an outfit image.', 'spwo'),
        'id'      => 'spwo_outfit_image',
        'type'    => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
            'text' => array(
              'add_upload_file_text' => 'Add Outfit'
            )
        ),
    ) );

    $outfit_points = $cmb->add_field( array(
    	'id'          => 'outfit_points',
    	'type'        => 'group',
    	// 'description' => __( 'Manage your image outfit interest points.', 'spwo' ),
    	'options'     => array(
    		'group_title'   => __( 'Interest Point {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
    		'add_button'    => __( 'Add Another Interest Point', 'cmb2' ),
    		'remove_button' => __( 'Remove Interest Point', 'cmb2' ),
    		'sortable'      => false, // beta
    		'closed'     => true, // true to have the groups closed by default
    	),
    ) );

    $cmb->add_group_field( $outfit_points, array(
    	'name'    => 'Choose Product',
    	'id'      => $prefix . 'linked_product',
    	'desc'    => 'Choose the product that corresponds to this Interest Point',
    	'type'    => 'pw_select',
    	'options' => $this->spwo_get_products(),
    ) );

    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $outfit_points, array(
    	'name' => 'Point Position',
    	'id'   => 'point_position',
    	'type' => 'text', // change to type hidden after production
    	// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
  }

  public function spwo_get_products( $query_args = array() ) {
    global $product;

    $args = wp_parse_args( $query_args, array(
        'post_type'   => 'product',
        'post_status' => array( 'publish' ),
        'posts_per_page' => -1,
        'orderby'     => 'menu_order',
        'order'       => 'ASC'
    ) );

    $product_names = array();

    // return post type as options
    $products = get_posts( $args );

    if ( $products ) {
      foreach ( $products as $product ) {
        $variation = wc_get_product($product);
        $product_names[ $product->ID ] = $variation->get_formatted_name();
      }
    }

    return $product_names;
  }

  // Shortcodes
  public function add_shortcodes(){
    add_shortcode( 'spwo-single-outfit', array(
      '\SP_Woocommerce_Outfits\Shortcodes\SPWO_Single_Outfit',
      'single-outfit'
    ) );
    add_shortcode( 'spwo-all-outfits', array(
      '\SP_Woocommerce_Outfits\Shortcodes\SPWO_All_Outfits',
      'all-outfits'
    ) );
  }


}
?>
