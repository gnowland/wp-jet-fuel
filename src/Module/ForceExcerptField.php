<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: force-excerpt-field
 *
 * Force visibility of excerpt on edit screen
 *
 * @example jetfuel('force-excerpt-field', $post_type(string|array));
 *
 * @link https://developer.wordpress.org/reference/hooks/hidden_meta_boxes
 * @link https://developer.wordpress.org/reference/hooks/init
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class ForceExcerptField extends Instance {
    protected $options;

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->options = ['post', 'page'];
        $this->setDefaultConfig(['all']);
        return $this;
    }

    protected function hook() {
        // Force display of excerpt field
        add_action('hidden_meta_boxes', [$this, 'forceExcerptField'], 10, 2);
        // Force enable excerpt for Page post type
        if (in_array('all', $this->config) || in_array('page', $this->config)) {
            add_action('init', [$this, 'enableExcerptForPages']);
        }
    }

    function forceExcerptField( $hidden, $screen ) {
        if (in_array('all', $this->config)) {
            if (in_array($screen->id, $this->options)) {
                if(($key = array_search('postexcerpt', $hidden)) !== false) {
                    unset($hidden[$key]);
                }
            }
        } elseif (in_array($screen->id, $this->config)) {
            if(($key = array_search('postexcerpt', $hidden)) !== false) {
                unset($hidden[$key]);
            }
        }
        return $hidden;
    }

    function enableExcerptForPages() {
        add_post_type_support( 'page', 'excerpt' );
    }
}
