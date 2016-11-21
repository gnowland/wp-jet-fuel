<?php
/**
 * Titles
 *
 * @category titles
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Titles;

/**
 * Filter get_the_archive_title() function to remove displaying the strings
 * "Category:", "Tag:", "Author:", or "Archives:" before archive page titles.
 */
 function modify_archive_titles($title) {
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
add_filter( 'get_the_archive_title', __NAMESPACE__ . '\\modify_archive_titles' );
