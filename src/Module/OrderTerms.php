<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: order-terms
 *
 * Prevent WordPress from re-ordering terms checklist
 *
 * @example jetfuel('order-terms');
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_terms_checklist_args/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class OrderTerms extends Instance {
    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig('');
        return $this;
    }

    protected function hook() {
        add_filter('wp_terms_checklist_args', [$this, 'orderTerms']);
    }

    public function orderTerms($args) {
        $args['checked_ontop'] = false;
        return $args;
    }
}
