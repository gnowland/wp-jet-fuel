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
		// Unused tags: <img>,<video>,<audio>,<script>,<style>,<p>,<br>,<span>,<strong>,<b>,<em>,<i>,<ul>,<ol>,<li>
		$allowed_tags = '<a>';
		$excerpt = strip_tags($excerpt, $allowed_tags);

		// Remove empty <a> tags from previously stripped images
		$excerpt = preg_replace('/<a href=.*?><\/a>/', '', $excerpt);

		// Remove empty paragraphs
		$excerpt = str_replace(array('<p>&nbsp;</p>'), '', $excerpt);
		$excerpt = preg_replace('/(<p>\s+<\/p>)/', '', $excerpt);
		$excerpt = str_replace(array('<p></p>'), '', $excerpt);

		// Set the excerpt word count and only break after sentence is complete.
		$excerpt_word_count = 35;
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
		$tokens = array();
		$excerpt_output = '';
		$count = 0;

		// Divide the string into tokens; HTML tags, or words, followed by any whitespace
		preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

		foreach ($tokens[0] as $key => $token) {

			$token = str_replace('&nbsp;', '', $token);
			$token = ltrim($token);

			if (empty($token)) {
				continue;
			}

			if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) {
			// Limit reached, continue until , ; ? . or ! occur at the end
					$excerpt_output .= trim($token);
					break;
			}

			// Add words to complete sentence
			$count++;

			// Append what's left of the token
			$excerpt_output .= $token;
		}

		// Remove last punctuation (to be replaed with ...)
		$excerpt_output = substr($excerpt_output, 0, -1);

		$excerpt = trim(force_balance_tags($excerpt_output));

		// Add punctuation to the last word of paragraphs that don't have any
		$excerpt = preg_replace("/\s+\n\n+/", ". ", $excerpt);
		$excerpt = str_replace(".. ", ". ", $excerpt);

	}

	$excerpt_end = '&hellip;&nbsp;<a href="' . esc_url( get_permalink() ) . '" class="read-more">' . __('Read More', 'wp-jet-fuel') . '</a>';
	$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

	// Add "Read More" inside last HTML tag
	$pos = strrpos($excerpt, '</');
	if ($pos !== false){
		// Add "read more" next to last word
		$excerpt = substr_replace($excerpt, $excerpt_end, $pos, 0);
	} else {
		$excerpt = $excerpt . $excerpt_end;
	}

	// Add "Read More" after the content
	//$excerpt .= $excerpt_more; /*Add read more in new paragraph */

	return apply_filters('custom_excerpt', $excerpt, $raw_excerpt);
}
// the_excerpt();
remove_filter('the_excerpt', 'wpautop');

// get_the_excerpt();
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', __NAMESPACE__ . '\\custom_excerpt');
