<?php
/**
 * Adds Custom Post Types
 *
 * @category custom-post-types
 * @package  WPJetFuel
 * @author   Gifford Nowland
 * @link     http://generatewp.com/post-type/
 *
 * REMEMBER: You must manually flush the rewrite rules by visiting the Settings > Permalinks page
 * and saving the permalink structure before new custom post type rewrites will show correctly!
 *
 * **************** IMPORTANT! ****************
 * If "taxonomies" is set the post type base name must also be included in the
 * $post_types array for the chosen taxonomy(ies) in custom-taxonomies.php!
 *
 * NOTE: Slugs should be in the form of: "some-name"
 *
 */

namespace WPJetFuel\PostTypes;

/**
 *  Register Custom Post Types
 */
function register_custom_post_types() {

	/**
	 * Available "Supports":
	 *   'title', 'editor', 'author', thumbnail', 'excerpt', 'trackbacks', 'custom-fields' (metadata), 'comments', 'revisions',
	 *     'page-attributes' (template, menu order) (...only appears when hierarchical is set to 'true'),
	 *     'post-formats' (aside, gallery, link, image, quote, status, video, audio, chat)
	 */

	// Set up each post types as an array below:
	$custom_post_types = array(

//		'_________' => array(
//			'name_singular' => '',
//			'name_plural'   => '',
//			//'menu_name'		 => 'name_plural by default',
//			'description'   => '',
//			'supports'      => array(),
//			'taxonomies'    => array('taxonomy_name'),
//			'hierarchical'  => true,
//			'has_archive'   => false,
//			'dashicon'      => '',
//			//'slug'          => 'array key by default'
//		)

	);

	foreach( $custom_post_types as $custom_post_type => $field){

		if( isset($field['name_singular']) ){ $name_single = $field['name_singular']; } else { $name_single = ''; }
		if( isset($field['name_plural'])   ){ $name_plural = $field['name_plural']; } else { $name_plural = ''; }
		if( isset($field['menu_name'])     ){ $menu_name = $field['menu_name']; } else { $menu_name = $name_plural; }
		if( isset($field['description'])   ){ $description = $field['description']; } else { $description = ''; }
		if( isset($field['supports'])      ){ $supports = $field['supports']; } else { $supports = array('title', 'editor'); }
		if( isset($field['taxonomies'])    ){ $taxonomies = $field['taxonomies']; } else { $taxonomies = array(); }
		if( isset($field['hierarchical'])  ){ $hierarchical = $field['hierarchical']; } else { $hierarchical = false; }
		if(!isset($field['has_archive'])   ){ $has_archive = $slug; } else {
			if( $field['has_archive']        ){ $has_archive = $slug; } else { $has_archive = $field['has_archive']; }
		}
		if( isset($field['dashicon'])      ){ $dashicon = $field['dashicon']; } else { $dashicon = ''; }
		if( isset($field['slug'])          ){ $slug = $field['slug']; } else { $slug = $custom_post_type; }

		$labels = array(
			'name'                => _x( $name_plural, 'Post Type General Name', 'wp-jet-fuel' ),
			'singular_name'       => _x( $name_single, 'Post Type Singular Name', 'wp-jet-fuel' ),
			'menu_name'           => __( $menu_name, 'wp-jet-fuel' ),
			'name_admin_bar'      => __( $menu_name, 'wp-jet-fuel' ),
			'parent_item_colon'   => __( 'Parent '.$name_single.':', 'wp-jet-fuel' ),
			'all_items'           => __( 'All '.$name_plural, 'wp-jet-fuel' ),
			'add_new_item'        => __( 'Add New '.$name_single, 'wp-jet-fuel' ),
			'add_new'             => __( 'Add New', 'wp-jet-fuel' ),
			'new_item'            => __( 'New '.$name_single, 'wp-jet-fuel' ),
			'edit_item'           => __( 'Edit '.$name_single, 'wp-jet-fuel' ),
			'update_item'         => __( 'Update '.$name_single, 'wp-jet-fuel' ),
			'view_item'           => __( 'View '.$name_single, 'wp-jet-fuel' ),
			'search_items'        => __( 'Search '.$name_plural, 'wp-jet-fuel' ),
			'not_found'           => __( 'No '.$name_plural.' found', 'wp-jet-fuel' ),
			'not_found_in_trash'  => __( 'No '.$name_plural.' found in Trash', 'wp-jet-fuel' ),
		);
		$args = array(
			'label'               => __( $custom_post_type, 'wp-jet-fuel' ),
			'description'         => __( $description, 'wp-jet-fuel' ),
			'labels'              => $labels,
			'supports'            => $supports,
			'taxonomies'          => $taxonomies,
			'hierarchical'        => $hierarchical,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			//'menu_position'       => 5,
			'menu_icon'           => $dashicon,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => $has_archive,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => array( 'slug' => $slug, 'with_front' => false, 'pages' => true, 'feeds' => true ),
			'capability_type'     => 'page'
		);
		register_post_type( $custom_post_type, $args );

	} // end foreach
} // end function

// Hook into the 'init' action
add_action( 'init', __NAMESPACE__ . '\\register_custom_post_types' );
