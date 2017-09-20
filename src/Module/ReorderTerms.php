<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: reorder-terms
 *
 * Prevent WordPress from re-ordering terms checklist
 *
 * @example jetfuel('reorder-terms', $config(bool));
 * @param   bool $config  false
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_terms_checklist_args/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class ReorderTerms extends Instance {
    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig('false');
        return $this;
    }

    protected function hook() {
        add_filter('wp_terms_checklist_args', [$this, 'reorderTerms']);
    }

    public function reorderTerms($args) {
        $args['checked_ontop'] = $this->config;
        return $args;
    }
}
