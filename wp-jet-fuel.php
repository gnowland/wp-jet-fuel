<?php

/**
 *
 * @link    https://github.com/gnowland/wp-jet-fuel
 * @since   0.0.1
 * @package WPJetFuel
 *
 * @wordpress-plugin
 * Plugin Name:  WordPress Jet Fuel
 * Plugin URI:   https://github.com/gnowland/wp-jet-fuel
 * Description:  Facilitates the addition of custom functionality to a WordPress website, including Custom Post Types, Meta Fields, Widgets, Taxonomies, Shortcodes, Admin Modificaitons etc.
 * Version:      0.0.1
 * Author:       Gifford Nowland
 * Author URI:   http://giffordnowland.com/
 * License:      MIT
 *
 * Text Domain:  wp-jet-fuel
 * Domain Path:  /languages
 *
*/

namespace WPJetFuel;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die('Abort!');

/*
 * Automatically include all PHP files from a plugin subfolder while avoiding adding an unnecessary global
 * just to determine a path that is already available everywhere via WP core functions:
 *
 * Delay to 11 to ensure all other plugins, plugin classes are loaded first
 */
function plugin_init() {
	$plugin_base_dir = plugin_dir_path( __FILE__ );
	foreach ( glob( $plugin_base_dir . "inc/*.php" ) as $file ) {
	  include_once $file;
	}

	// Admin
	if( is_admin() ) {
		foreach ( glob( $plugin_base_dir . "inc/admin/*.php" ) as $file ) {
			include_once $file;
		}
	}

	// Customizer
	foreach ( glob( $plugin_base_dir . "inc/customizer/*.php" ) as $file ) {
		include_once $file;
	}

	// Widgets
	foreach ( glob( $plugin_base_dir . "inc/widgets/*.php" ) as $file ) {
		include_once $file;
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\plugin_init', 11);
