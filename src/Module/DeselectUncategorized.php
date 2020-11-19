<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: deselect-uncategorized
 *
 * Automatically deselects the uncategorized category when another category is selected.
 *
 * @example jetfuel('deselect-uncategorized');
 *
 * @link https://developer.wordpress.org/reference/hooks/save_post
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 2.6.0
 */
class DeselectUncategorized extends Instance {
    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([]);
        return $this;
    }

    protected function hook() {
        add_action( 'admin_enqueue_scripts', [$this, 'addEditorJs'], 10, 1 );

    }

     public function addEditorJs( $hook_suffix ) {
         if ( $hook_suffix === 'post-new.php' || $hook_suffix === 'post.php' ) {
            wp_enqueue_script( 
                'deselect_uncategorized',
                plugin_dir_url( __DIR__ ) . 'js/deselectUncategorized.js',
                [ 'lodash', 'wp-api-fetch', 'wp-components', 'wp-element', 'wp-i18n', 'wp-polyfill', 'wp-url' ],
                '1.0.0',
                true
            );

            wp_localize_script( 'deselect_uncategorized', 'scriptParams', [
                'defaultCategory' => get_option( 'default_category' )
            ] );
        }
    }
}
