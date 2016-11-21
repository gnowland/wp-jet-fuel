<?php
/**
 * Modify Core Post Type Supports
 *
 * @category post-type-supports
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\PostTypeSupports;

/**
 * Remove supports from existing post types
 */
function remove_post_object_supports() {
	remove_post_type_support( 'page', 'comments' );
	remove_post_type_support( 'page', 'author' );
}
add_action( 'init', __NAMESPACE__ . '\\remove_post_object_supports' );

/**
 * Prevent WordPress from re-ordering terms checklist
 */
function reorder_terms_checklist($args) {
    $args['checked_ontop'] = false;
    return $args;
}
add_filter('wp_terms_checklist_args', __NAMESPACE__ . '\\reorder_terms_checklist');
