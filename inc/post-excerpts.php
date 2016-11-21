<?php
/**
 * Clean up the_excerpt()
 *
 * @category post-excerpts
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 * Use:
 * <?php echo get_the_excerpt(); ?>
 * <?php the_excerpt(); ?>
 *
 */

namespace WPJetFuel\PostExcerpts;

function custom_excerpt($excerpt) {

	$raw_excerpt = $excerpt;

	// Check if a user-supplied excerpt exists,
	// skip excerpt generation if a user-supplied excerpt exists
	if ( '' == $excerpt ) {

		$excerpt = get_the_content('');
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);

		// Allow certain tags
		// Unused tags: <img>,<video>,<audio>,<script>,<style>,<br>
		$allowed_tags = '<p>,<span>,<em>,<i>,<strong>,<b>,<ul>,<ol>,<li>,<a>';
		$excerpt = strip_tags($excerpt, $allowed_tags);

		// Remove empty paragraphs
		$excerpt = preg_replace('/<a href=.*?><\/a>/', '', $excerpt);
		$excerpt = str_replace(array('<p>&nbsp;</p>'), '', $excerpt);
		$excerpt = preg_replace('/(<p>\s+<\/p>)/', '', $excerpt);
		$excerpt = str_replace(array('<p></p>'), '', $excerpt);

		// Set the excerpt word count and only break after sentence is complete.
		$excerpt_word_count = 55;
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
		$tokens = array();
		$excerptOutput = '';
		$count = 0;

		// Divide the string into tokens; HTML tags, or words, followed by any whitespace
		preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

		foreach ($tokens[0] as $token) {

			if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) {
			// Limit reached, continue until , ; ? . or ! occur at the end
					$excerptOutput .= trim($token);
					break;
			}

			// Add words to complete sentence
			$count++;

			// Append what's left of the token
			$excerptOutput .= $token;
		}

		$excerpt = trim(force_balance_tags($excerptOutput));

		$excerpt_end = '<a href="'. esc_url( get_permalink() ).'" class="read-more">' . __('&nbsp;Read More', 'wp-jet-fuel') . '</a>';
		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

		// Inside last HTML tag
		$pos = strrpos($excerpt, '</');
		if ($pos !== false){
			// Add "read more" next to last word
			$excerpt = substr_replace($excerpt, $excerpt_end, $pos, 0);
		} else {
			$excerpt = $excerpt . $excerpt_end;
		}

		// After the content
		//$excerpt .= $excerpt_more; /*Add read more in new paragraph */

		return $excerpt;

	}
	return apply_filters('custom_excerpt', $excerpt, $raw_excerpt);

}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', __NAMESPACE__ . '\\custom_excerpt');
