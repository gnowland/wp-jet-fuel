<?php
/**
 * Loads admin functions from admin subfolder
 *
 * @category admin
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Admin;


if( is_admin() ) {

	/*
	 * Automatically include all PHP files from a plugin subfolder while avoiding adding an unnecessary global
	 * just to determine a path that is already available everywhere via WP core functions:
	 */
	foreach ( glob( plugin_dir_path( __FILE__ ) . "admin/*.php" ) as $file ) {
		include_once $file;
	}

} // /is_admin()
