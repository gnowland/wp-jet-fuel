<?php
/**
 * Admin Menu
 *
 * @category admin/menu
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Admin\Menu;


/**
 * Modify admin menu items
 */
function modify_admin_menu() {
	global $menu;
	$menu[] = array( '', 'read', 'separator-core', '', 'wp-menu-separator' ); // Add separator-core
	$menu[] = array( '', 'read', 'separator-plugins', '', 'wp-menu-separator' ); // Add separator-core
}
add_action( 'admin_menu', __NAMESPACE__ . '\\modify_admin_menu', 11 );


/**
 * Rearrange the admin menu
 */
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;

	$menu_ord = array(
		// Dashboard
		'index.php', // Dashboard
		'themes.php', // Appearance
		'upload.php', // Media
		'link-manager.php', // Links
		//'site-options', // Custom Plugin Page

		// Content
		'separator1', // First separator
		'edit.php?post_type=page', // Pages
		//'edit.php', // Posts/Blog/News

		// Plugins
		'separator-plugins', // Third Separatpr

		// Users
		//'separator2', // Fourth separator
		'users.php', // Users
		//'edit-comments.php', // Comments

		// Core
		'separator-core', // Fifth separator
		'plugins.php', // Plugins
		'tools.php', // Tools
		//'edit.php?post_type=acf-field-group', // ACF
		'options-general.php', // Settings


		// Everything else...
		'separator-last', // Last separator
		// ...automatically appears here
	);

	return $menu_ord;
}
add_filter('custom_menu_order', __NAMESPACE__ . '\\custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', __NAMESPACE__ . '\\custom_menu_order');


/**
 *  Remove Admin Menu Items
 */
function remove_menus(){
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_menus' );
