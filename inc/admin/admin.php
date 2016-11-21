<?php
/**
 * Admin Functions
 *
 * @category admin
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Admin\Admin;

/**
 *  Set allowed mime types in media uploader
 */
function allow_upload_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', __NAMESPACE__ . '\\allow_upload_mime_types');


/**
 *  Add custom CSS
 */
function custom_admin_css($hook) {
	if ( $hook != ('post.php' || 'toplevel_page_site-options') ) { return; }
	wp_enqueue_style( 'admin_css', plugin_dir_url( __FILE__ ) . 'css/admin.css', false, null );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\custom_admin_css', 20 );


/**
 * Remove dashboard widgets
 */
function disable_dashboard_widgets() {
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core'); // Quick Press Widget
}
add_action('admin_menu', __NAMESPACE__ . '\\disable_dashboard_widgets');

/**
 * Force Visibility of specific admin "Screen Options"
 */
function hidden_meta_boxes( $hidden, $screen ) {
	if(($key = array_search('postexcerpt', $hidden)) !== false) {
		unset($hidden[$key]);
	}
  return $hidden;
}
add_filter( 'hidden_meta_boxes', __NAMESPACE__ . '\\hidden_meta_boxes', 10, 2 );


/**
 * Custom Backend Footer
 */
function custom_admin_footer() {
	$location  = '';
	$author    = '';
	$authorurl = '';
	echo '<span id="footer-thankyou">Made with <span style="font-style:normal;font-size:0.8em;color:#D86565;">&hearts;</span> in ' + esc_attr($location) + ' by <a href="' + esc_url($authorurl) + '" target="_blank">' + esc_attr($author) + '</a></span>. ';
}
add_filter('admin_footer_text', __NAMESPACE__ . '\\custom_admin_footer');


/**
 * Change Priority of Featured Image Metabox
 */
function move_featured_image_metabox( $post_type, $post ){
	$post_type_object = get_post_type_object($post_type);
	remove_meta_box('postimagediv', null, 'side');
	add_meta_box('postimagediv', esc_html( $post_type_object->labels->featured_image ), 'post_thumbnail_meta_box', null, 'side', 'high');
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\\move_featured_image_metabox', 10, 2 );


/**
 * Add Excerpt box to Pages.
 */
function add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', __NAMESPACE__ . '\\add_excerpts_to_pages' );
