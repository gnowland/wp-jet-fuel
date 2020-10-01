<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: reorder-menu
 *
 * Hooks into menu_order to reorder menu items
 *
 * @example jetfuel('reorder-menu', $config(array));
 * @param   array|string $config
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @link https://developer.wordpress.org/reference/hooks/custom_menu_order/
 * @link https://developer.wordpress.org/reference/hooks/menu_order/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class ReorderMenu extends Instance {
    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([
            // Dashboard
            'index.php', // Dashboard
            'themes.php', // Appearance
            'upload.php', // Media
            'link-manager.php', // Links

            // Content
            'separator1', // First separator
            'edit.php?post_type=page', // Pages
            'edit.php', // Posts/Blog/News

            // Plugins
            'separator-plugins', // Third Separatpr

            // Users
            'separator2', // Fourth separator
            'users.php', // Users
            'edit-comments.php', // Comments

            // Core
            'separator-core', // Fifth separator
            'plugins.php', // Plugins
            'tools.php', // Tools
            'edit.php?post_type=acf-field-group', // ACF
            'options-general.php', // Settings


            // Everything else...
            'separator-last', // Last separator
            // ...automatically appears here
        ]);
        return $this;
    }

    protected function hook() {
        // Add extra spacers to menu
        add_action('admin_menu', [$this, 'addSpacers'], 11);
        // Rearrange the admin menu
        add_action('custom_menu_order', [$this, 'reorderMenu']);
        add_action('menu_order', [$this, 'reorderMenu']);
    }

    /**
    * Submodule: addSpacers
    *
    * Hooks into admin_menu to add additional spacers
    * as determined by $menu_order(array) values beginning with 'separator-'
    *
    * @example jetfuel('reorder-menu', $config(array['spacer-example']));
    * @param   array|string $config(array['spacer-example'])
    *
    * @link https://developer.wordpress.org/reference/hooks/admin_menu/
    *
    * @package WordPress
    * @subpackage WPJetFuel
    * @since 0.2.0
    * @version 2.2.0
    */
    public function addSpacers($menu_ord) {
      global $menu;
      $menu_ord = $this->config;

      foreach ($menu_ord as $menu_item) {
        if ( strpos($menu_item, 'separator-') === 0) {
          $menu[] = array( '', 'read', $menu_item, '', 'wp-menu-separator' ); // Add separator-core
        }
      }
    }

    public function reorderMenu($menu_ord) {
        if (!$menu_ord) return true;

        $menu_ord = $this->config;

        return $menu_ord;
    }
}
