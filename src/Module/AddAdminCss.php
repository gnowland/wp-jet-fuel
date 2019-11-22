<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: add-admin-css
 *
 * Add custom CSS to Admin
 *
 * @example jetfuel('add-admin-css');
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class AddAdminCss extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([]);
        return $this;
    }

    protected function hook() {
        add_action('admin_enqueue_scripts', [$this, 'addAdminCss'], 20);
    }

    public function addAdminCss($hook) {
        wp_enqueue_style( 'admin_css', plugin_dir_url( __DIR__ ) . 'css/admin.css', false, null );
    }

}
