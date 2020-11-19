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
        add_action( 'save_post', [$this, 'autoDeselectUncategorized'], 10, 3 );
    }

    public function autoDeselectUncategorized( $post_id, $post, $update ) {
        $categories = get_the_category( $post_id );
        $default_category = get_cat_name( get_option( 'default_category' ) );
        if( count( $categories ) >= 2 && in_category( $default_category, $post_id ) ) {
            wp_remove_object_terms( $post_id, $default_category, 'category' );
        }
    }
}
