<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: remove-comment-fields
 *
 * Remove specified fields from comments form
 *
 * @example jetfuel('remove-comment-fields', $fields(string|array));
 *
 * @param  string|array  $fields  The fields to remove
 *
 * @link https://developer.wordpress.org/reference/hooks/comment_form_default_fields
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 1.1.1
 */
class RemoveCommentFields extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig(['website']);
        return $this;
    }

    protected function hook() {
        add_filter('comment_form_default_fields', [$this, 'RemoveCommentFields']);
    }

    public function RemoveCommentFields($field) {
        foreach ($this->config as $f) {
            if( isset($field[$f]) ) {
                unset( $field[$f] );
            }
        }
        return $field;
    }

}
