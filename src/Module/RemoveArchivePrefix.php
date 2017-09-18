<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: remove-archive-prefix
 *
 * Filter get_the_archive_title() function to remove displaying the strings
 * "Category:", "Tag:", "Author:", or "Archives:" before archive page titles.
 *
 * @example jetfuel('remove-archive-prefix');
 *
 * @link https://developer.wordpress.org/reference/hooks/get_the_archive_title/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class RemoveArchivePrefix extends Instance {
    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig('');
        return $this;
    }

    protected function hook() {
        add_filter('get_the_archive_title', [$this, 'removeArchivePrefix']);
    }

    public function removeArchivePrefix($title) {
        if ( is_category() ) {
          $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
          $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
          $title = '<span class="vcard">' . get_the_author() . '</span>' ;
        } elseif ( is_post_type_archive() ) {
          $title = post_type_archive_title( '', false );
        } elseif ( is_tax() ) {
          $tax = get_taxonomy( get_queried_object()->taxonomy );
          $title = single_term_title( '', false );
        }
        return $title;
    }
}
