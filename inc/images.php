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
 * Add custom image sizes
 */
//function add_image_sizes(){
//	//               thumbnail            150  9999           // min
//	add_image_size( 'small',              300, 9999, false ); // 2x thumbnail
//	//               medium               600  9999           // 2x small
//	add_image_size( 'portrait',           600, 600, true   ); // 2z small, cropped
//	update_option( 'medium_large_size_w', 900 );              // medium_large
//	//               large               1200  9999           // 2x medium
//	add_image_size( 'extra_large',       1500, 9999, false ); // fill
//	add_image_size( 'jumbo',             1800, 9999, false ); // 2x medium_large
//	add_image_size( 'maximum',           2100, 9999, false ); // max
//}
//add_action( 'after_setup_theme', __NAMESPACE__ .'\\add_image_sizes' );


/**
 * Remove the <p> tag from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
 */
function filter_tags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter( 'the_content', __NAMESPACE__ . '\\filter_tags_on_images' );
