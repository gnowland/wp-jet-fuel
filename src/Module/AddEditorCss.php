<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: add-editor-css
 *
 * Add custom CSS to Edit Pages
 *
 * @example jetfuel('add-editor-css');
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class AddEditorCss extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([]);
        return $this;
    }

    protected function hook() {
        add_action('admin_enqueue_scripts', [$this, 'addEditorCss'], 20);
    }

    public function addEditorCss($hook) {
        if ( $hook === ('post.php' || 'toplevel_page_site-options') ) {
            wp_enqueue_style( 'editor_css', plugin_dir_url( __FILE__ ) . 'src/css/editor.css', false, null );
        }
    }

}
