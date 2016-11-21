<?php
/**
 * Rename Core Post Types
 *
 * @category admin/rename-posts
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Admin\RenamePosts;

/**
 * Rename Posts to News
 */

//function change_post_object_label() {
//
//	$name_singular = 'News Article';
//	$name_plural   = 'News Articles';
//	$menu_name     = 'News';
//	$menu_icon     = '';
//
//	// Setup Globals
//	global $wp_post_types;
//	$post_array = &$wp_post_types['post'];
//
//	// Change Labels
//	$labels = $post_array->labels;
//	$labels->name               = $name_plural;
//	$labels->singular_name      = $name_singular;
//	$labels->menu_name          = $menu_name;
//	$labels->name_admin_bar     = $menu_name;
//	$labels->parent_item_colon  = 'Parent ' . $name_singular;
//	$labels->all_items          = 'All ' . $name_plural;
//	$labels->add_new_item       = 'Add ' . $name_singular;
//	$labels->add_new            = 'Add New';
//	$labels->new_item           = 'New ' . $name_singular;
//	$labels->edit_item          = 'Edit ' . $name_singular;
//	$labels->update_item        = 'Update ' . $name_singular;
//	$labels->view_item          = 'View ' . $name_singular;
//	$labels->search_items       = 'Search ' . $name_plural;
//	$labels->not_found          = 'No ' . $name_plural . ' found';
//	$labels->not_found_in_trash = 'No ' . $name_plural . ' found in Trash';
//
//	// Change Icon
//	if (!empty($menu_icon)){
//		$post_array->menu_icon    = $menu_icon;
//	}
//
//}
//add_action( 'init', __NAMESPACE__ . '\\change_post_object_label' );
