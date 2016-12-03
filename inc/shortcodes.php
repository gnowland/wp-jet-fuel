<?php
/**
 * Shortcodes
 *
 * @category shortcodes
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Shortcodes;

/**
 * [year] Shortcode
 *
 * Returns the Current Year as a string in four digits.
 *
 * @return   string              Current Year
 */
function year() {
	$date = getdate();
	return $date['year'];
}
add_shortcode( 'year', __NAMESPACE__ . '\\year' );

/**
 * [search] Shortcode
 *
 * Returns an html object containing the site search form.
 *
 * @return   html                Site Search Form
 */
function search() {
	return get_search_form(false);
}
//add_shortcode( 'search', __NAMESPACE__ . '\\search' );

/**
 * [site-url] Shortcode
 *
 * Returns the site url from settings -> general.
 *
 * @return   string                Site URL
 */
function site_url() {
	$url = get_site_url();
	return esc_url($url);
}
add_shortcode( 'site_url', __NAMESPACE__ . '\\site_url' );

/**
 * [site-name] Shortcode
 *
 * Returns the site name from settings -> general.
 *
 * @return   string                Site Name
 */
function site_name() {
	$name = get_bloginfo('name');
	return esc_attr($name);
}
add_shortcode( 'site_name', __NAMESPACE__ . '\\site_name' );
