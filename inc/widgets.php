<?php
/**
 * Adds Custom Widgets & adjusts settings of default widgets
 *
 * @category widgets
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Widgets;

/**
 *  Allow PHP in 'Text' Widget
 */
function text_widget_php_support($text) {
	ob_start();
		eval( '?>' . $text );
		$text = ob_get_contents();
	ob_end_clean();

	return $text;
}
add_filter('widget_text', __NAMESPACE__ . '\\text_widget_php_support');

 /*
 * Automatically include all PHP files from a plugin subfolder while avoiding adding an unnecessary global
 * just to determine a path that is already available everywhere via WP core functions:
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . "widgets/*.php" ) as $file ) {
	include_once $file;
}
