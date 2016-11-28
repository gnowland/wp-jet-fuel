<?php
/**
 * Adds Custom Taxonomies
 *
 * @category post-taxonomies
 * @package  WPJetFuel
 * @author   Gifford Nowland
 * @link     http://generatewp.com/taxonomy/
 *
 * **************** IMPORTANT! ****************
 * Taxonomy base names must also be added to the $taxonomies
 * array for the associated post_type in post-types.php!
 *
 * NOTE: Slugs should be in the form of: "some-name"
 *
 */

namespace WPJetFuel\PostTaxonomies;

/**
 * Register Custom Taxonomies
 */
function custom_taxonomies() {

	// Set up each taxonomy as an array below:
	$custom_taxonomies = array(

//		'' => array(
//			'name_singular' => '',
//			'name_plural'   => '',
//			//'menu_name'     => 'name_singular by default',
//			'post_types'    => array('post_type_name'),
//			'hierarchical'  => false,
//			//'slug'          => 'slug by default',
//			//'show_ui'       => false,
//			//public          => false
//		)

	);

	foreach( $custom_taxonomies as $custom_taxonomy => $field){

		if( isset($field['name_singular']) ){ $name_single = $field['name_singular']; } else { $name_single = ''; }
		if( isset($field['name_plural'])   ){ $name_plural = $field['name_plural']; } else { $name_plural = ''; }
		if( isset($field['menu_name'])     ){ $menu_name = $field['menu_name']; } else { $menu_name = $name_plural; }
		if( isset($field['post_types'])    ){ $post_types = $field['post_types']; } else { $post_types = array(); }
		if( isset($field['hierarchical'])  ){ $hierarchical = $field['hierarchical']; } else { $hierarchical = false; }
		if( isset($field['slug'])          ){ $slug = $field['slug']; } else { $slug = $custom_taxonomy; }
		if( isset($field['show_ui'])       ){ $show_ui = $field['show_ui']; } else { $show_ui = true; }
		if( isset($field['public'])       ){ $public = $field['public']; } else { $public = true; }


		$labels = array(
			'name'                       => _x( $name_plural, 'Taxonomy General Name', 'wp-jet-fuel'),
			'singular_name'              => _x( $name_single, 'Taxonomy Singular Name', 'wp-jet-fuel'),
			'menu_name'                  => __( $menu_name, 'wp-jet-fuel'),
			'parent_item'                => __( 'Parent '.$name_single, 'wp-jet-fuel'),
			'parent_item_colon'          => __( 'Parent '.$name_single.':', 'wp-jet-fuel'),
			'all_items'                  => __( 'All '.$name_plural, 'wp-jet-fuel'),
			'add_new_item'               => __( 'Add New '.$name_single, 'wp-jet-fuel'),
			'new_item_name'              => __( 'New '.$name_single, 'wp-jet-fuel'),
			'edit_item'                  => __( 'Edit '.$name_single, 'wp-jet-fuel'),
			'update_item'                => __( 'Update '.$name_single, 'wp-jet-fuel'),
			'view_item'                  => __( 'View '.$name_single, 'wp-jet-fuel'),
			'search_items'               => __( 'Search '.$name_plural, 'wp-jet-fuel'),
			'not_found'                  => __( 'No '.$name_plural.' found', 'wp-jet-fuel'),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => $hierarchical,
			'public'                     => $public,
			'show_ui'                    => $show_ui,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'rewrite'                    => array( 'slug' => $slug, 'with_front' => false, 'hierarchical' => $hierarchical ),
			'show_tagcloud'              => true
		);
		register_taxonomy( $custom_taxonomy, $post_types, $args );

	} // end foreach
} // end function

// Hook into the 'init' action
add_action( 'init', __NAMESPACE__ . '\\custom_taxonomies' );
