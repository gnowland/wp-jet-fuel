<?php
/**
 * Image Functions
 *
 * @category images
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Images;

/**
 * Remove the <p> tag from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
 */
function filter_tags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter( 'the_content', __NAMESPACE__ . '\\filter_tags_on_images' );


/**
 * Register custom image sizes
 */
function add_image_sizes(){
//		              'thumbnail'            300, 9999					 Set in admin
		add_image_size( 'small',               500, 9999, false );
//		              'medium'               800, 9999					 Set in admin
//	 update_option( 'medium_large_size_w', 1080 );						 !!! RUN ONCE !!! @TODO: Button click?
//		              'large'                1400  9999					 Set in admin
		add_image_size( 'extra_large',         1600, 9999, false );
		add_image_size( 'giant',               2000, 9999, false );
		add_image_size( 'jumbo',               2600, 9999, false );
//									'original'						 3000+
}
add_action( 'after_setup_theme', __NAMESPACE__ .'\\add_image_sizes' );


/**
 * Display all registered image sizes in Settings > Media
 */
if( is_admin() ) {

	function render_image_size_css() { ?>
		<style>
			.registered-image-sizes td { padding-top: 0; padding-bottom: 2px; }
			.registered-image-sizes thead { font-weight: 600; }
			.registered-image-sizes tbody tr td:not(:first-of-type) { text-align: center; }
			.registered-image-sizes td:first-of-type { padding-left: 0; }
		</style>
	<?php
	}
	add_action( 'admin_head-options-media.php', __NAMESPACE__ . '\\render_image_size_css' );

	function sort_by_width($a, $b) {
		return $a['width'] - $b['width'];
	}

	function get_image_sizes() {
		global $_wp_additional_image_sizes;
		$sizes = array();
		$image_sizes = get_intermediate_image_sizes();

		if( ! empty( $image_sizes ) && ( is_array( $image_sizes ) || is_object( $image_sizes ) ) ) {
			foreach( $image_sizes as $image_size ) {
				if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$sizes[ $image_size ]['width']  = get_option( $image_size . '_size_w' );
					$sizes[ $image_size ]['height'] = get_option( $image_size . '_size_h' );
					$sizes[ $image_size ]['crop']   = get_option( $image_size . '_crop' );

					// Set defaults for medium_large
					if ( $image_size === 'medium_large' && $sizes[ $image_size ]['width'] == 0 ) { $sizes[ $image_size ]['width'] = '768'; }
					if ( $image_size === 'medium_large' && $sizes[ $image_size ]['height'] == 0 ) { $sizes[ $image_size ]['height'] = '9999'; }

				} elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {
					$sizes[ $image_size ] = array(
						'width'  => $_wp_additional_image_sizes[ $image_size ]['width'],
						'height' => $_wp_additional_image_sizes[ $image_size ]['height'],
						'crop'   => $_wp_additional_image_sizes[ $image_size ]['crop']
					);
				}
			}
		}

		uasort($sizes, __NAMESPACE__ . '\\sort_by_width');

		return $sizes;
	}

	function render_image_sizes() {
		$image_sizes = get_image_sizes();

		$output = '<table class="registered-image-sizes"><thead><tr><td>' . __('Name', 'wp-jet-fuel') . '</td><td>' . __('Width', 'wp-jet-fuel') . '</td><td>' . __('Height', 'wp-jet-fuel') . '</td><td>' . __('Crop', 'wp-jet-fuel') . '</td></tr></thead><tbody>';
		foreach ( $image_sizes as $size => $meta ) {
			$output .= '<tr><td>' . esc_attr($size) . '</td><td>' . (int) $meta['width'] . '</td><td>' . (int) $meta['height'] . '</td><td>';

			if( (bool) $meta['crop'] === true ) {
				$output .= '&#x2713;';
			}

			$output .= '</td></tr></li>';
		}
		$output .= '</tbody></table>';

		echo $output;
	}

	function image_sizes() {
		add_settings_field(
			'image-sizes',
			__('Registered Sizes', 'wp-jet-fuel'),
			__NAMESPACE__ . '\\render_image_sizes',
			'media',
			'default'
		);
	}
	add_action( 'admin_init', __NAMESPACE__ . '\\image_sizes' );
}
