<?php
/* Bones Custom Post Type Example
This page walks you through creating
a custom post type and taxonomies. You
can edit this one or copy the following code
to create another one.

I put this in a separate file so as to
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

if ( ! function_exists('outfits') ) {
	function outfits() {

		$labels = array(
			'name'                  => _x( 'Outfits', 'Post Type General Name', 'screenpartner' ),
			'singular_name'         => _x( 'Outfit', 'Post Type Singular Name', 'screenpartner' ),
			'menu_name'             => __( 'Outfits', 'screenpartner' ),
			'name_admin_bar'        => __( 'Outfit', 'screenpartner' ),
			'archives'              => __( 'Outfitarkiv', 'screenpartner' ),
			'attributes'            => __( 'Outfit attributter', 'screenpartner' ),
			'parent_item_colon'     => __( 'Foreldreoutfit', 'screenpartner' ),
			'all_items'             => __( 'Alle outfits', 'screenpartner' ),
			'add_new_item'          => __( 'Legg til nytt outfit', 'screenpartner' ),
			'add_new'               => __( 'Legg til', 'screenpartner' ),
			'new_item'              => __( 'Nytt outfit', 'screenpartner' ),
			'edit_item'             => __( 'Rediger outfit', 'screenpartner' ),
			'update_item'           => __( 'Oppdater outfit', 'screenpartner' ),
			'view_item'             => __( 'Vis outfit', 'screenpartner' ),
			'view_items'            => __( 'Vis outfits', 'screenpartner' ),
			'search_items'          => __( 'Søk outfit', 'screenpartner' ),
			'not_found'             => __( 'Ikke funnet', 'screenpartner' ),
			'not_found_in_trash'    => __( 'Ikke funnet i søppelkassen', 'screenpartner' ),
			'featured_image'        => __( 'Fremhevet bilde', 'screenpartner' ),
			'set_featured_image'    => __( 'Velg fremhevet bilde', 'screenpartner' ),
			'remove_featured_image' => __( 'Fjern fremhevet bilde', 'screenpartner' ),
			'use_featured_image'    => __( 'Bruk som fremhevet bilde', 'screenpartner' ),
			'insert_into_item'      => __( 'Sett inn i outfit', 'screenpartner' ),
			'uploaded_to_this_item' => __( 'Lastet opp til dette outfitet', 'screenpartner' ),
			'items_list'            => __( 'Outfitliste', 'screenpartner' ),
			'items_list_navigation' => __( 'Outfitlistenavigasjon', 'screenpartner' ),
			'filter_items_list'     => __( 'Filtrer outfitliste', 'screenpartner' ),
		);
		$args = array(
			'label'                 => __( 'Outfit', 'screenpartner' ),
			'description'           => __( 'Alle outfits går her.', 'screenpartner' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'revisions', ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-businessman',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'outfits', $args );

	}
	add_action( 'init', 'outfits', 0 );
}

?>
