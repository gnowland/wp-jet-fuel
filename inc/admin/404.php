<?php
/**
 * 404 Page Selection
 *
 * @category admin/404
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Admin\FourOhFour;

/**
 * Add 404 Page Select to Settings > Reading
 */
function fourohfour_select() {
	echo '<ul style="margin-top:0;"><li>',
		wp_dropdown_pages( array(
			'name' => 'fourohfour',
			'echo' => 0,
			'show_option_none' => __( '&mdash; Select &mdash;' ),
			'option_none_value' => '0',
			'selected' => get_option( 'fourohfour' )
		) ),
	'</li></ul>';
}

function fourohfour_settings() {

	add_settings_field(
		'fourohfour',
		__('404 Page', 'wp-jet-fuel'),
		__NAMESPACE__ . '\\fourohfour_select',
		'reading',
		'default'
	);

	register_setting('reading','fourohfour');
}
add_action( 'admin_init', __NAMESPACE__ . '\\fourohfour_settings' );


/**
 * Label 404 Page in 'Pages' List
 */
function fourohfour_state( $states, $post ) {
	global $post;
	$fourohfour_page = get_site_option('fourohfour');

	if ( !empty($fourohfour_page) && $post->ID == $fourohfour_page ) {
		$states[] = __('404 Page', 'wp-jet-fuel');
	}

	return $states;
}
add_filter( 'display_post_states', __NAMESPACE__ . '\\fourohfour_state' , 10, 2 );