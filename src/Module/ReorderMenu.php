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

    public function addSpacers() {
        global $menu;
        $menu[] = array( '', 'read', 'separator-core', '', 'wp-menu-separator' ); // Add separator-core
        $menu[] = array( '', 'read', 'separator-plugins', '', 'wp-menu-separator' ); // Add separator-plugins
    }

    public function reorderMenu($menu_ord) {
        if (!$menu_ord) return true;

        $menu_ord = $this->config;

        return $menu_ord;
    }
}
