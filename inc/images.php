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
