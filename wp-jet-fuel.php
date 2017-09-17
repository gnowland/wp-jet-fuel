<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:  WordPress Jet Fuel
 * Plugin URI:   https://github.com/gnowland/wp-jet-fuel
 * Description:  Facilitates the addition of custom functionality to a WordPress website, including Custom Post Types, Meta Fields, Widgets, Taxonomies, Shortcodes, Admin Modificaitons etc.
 * Version:      0.2.0
 * Author:       Gifford Nowland
 * Author URI:   http://giffordnowland.com/
 * License:      MIT
 *
 * Text Domain:  jetfuel
 * Domain Path:  /languages
 *
 * @link    https://github.com/gnowland/wp-jet-fuel
 * @package WordPress
 * @subpackage WPJetFuel
 *
 * Attribution:
 * I owe a ton of inspiration for version 0.2.0 of the plugin to https://github.com/soberwp/intervention
 *
*/

namespace Gnowland\JetFuel;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die('Abort!');

/**
 * Setup $loader object from function jetfuel
 *
 * @param string $module
 * @param string|array $config
 */
function jetfuel($module = false, $config = false )
{
    $class = __NAMESPACE__ . '\Module\\' . str_replace('-', '', ucwords($module, '-'));
    $instance = (new $class($config))->run();
}
