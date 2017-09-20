<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: reorder-featured-image
 *
 * Move the Featured Image metabox to the top
 *
 * @example jetfuel('reorder-featured-image');
 *
 * @link https://developer.wordpress.org/reference/hooks/add_meta_boxes
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class ReorderFeaturedImage extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([]);
        return $this;
    }

    protected function hook() {
        // Change Priority of Featured Image Metabox
        add_action('add_meta_boxes', [$this, 'moveFeaturedImageMetabox'], 10, 2);
    }

    public function moveFeaturedImageMetabox( $post_type, $post ){
        $post_type_object = get_post_type_object($post_type);
        if (post_type_supports($post_type_object->name, 'thumbnail')) {
            remove_meta_box('postimagediv', null, 'side');
            add_meta_box('postimagediv', esc_html( $post_type_object->labels->featured_image ), 'post_thumbnail_meta_box', null, 'side', 'high');
        }
    }
}
