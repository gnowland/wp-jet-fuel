<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: customize-excerpts
 *
 * Clean up the_excerpt()
 *
 * @example jetfuel('customize-excerpts', $config(string|array), $length(int));
 *
 * @link https://developer.wordpress.org/reference/hooks/the_excerpt/
 * @link https://developer.wordpress.org/reference/hooks/get_the_excerpt
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 *
 *  Use:
 * <?php echo get_the_excerpt(); ?> or
 * <?php the_excerpt(); ?>
 *
 */
class CustomizeExcerpts extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig('55', 'option');
        $this->setDefaultConfig('formatting');
        return $this;
    }

    protected function hook() {
        // Amend the_excerpt();
        remove_filter('the_excerpt', 'wpautop');
        // Amend get_the_excerpt();
        remove_filter('get_the_excerpt', 'wp_trim_excerpt');
        remove_filter('excerpt_more', 'wp_embed_excerpt_more', 20);
        add_filter('get_the_excerpt', [$this, 'customizeExcerpt'], 10, 2);
    }

    public function customizeExcerpt($excerpt, $post) {
        // Check if a user-supplied excerpt exists,
        // skip excerpt generation if a user-supplied excerpt exists
        if ( '' === $excerpt ) {
            $excerpt = get_post_field('post_content', $post);
            $excerpt = strip_shortcodes( $excerpt );
            $excerpt = apply_filters('the_content', $excerpt);
            $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
        }

        // Allow tags
        $allowed_tags = [];
        if (in_array('all', $this->config)) {
            $allowed_tags = array_merge($allowed_tags, ['a', 'img', 'video', 'audio', 'p', 'br', 'span', 'strong', 'b', 'em', 'i', 'ul', 'ol', 'li', 'hr']);
        } else {
            if (in_array('formatting', $this->config)) {
                $allowed_tags = array_merge($allowed_tags, ['a', 'span', 'em', 'i', 'strong', 'b']);
            }
            if (in_array('newlines', $this->config)) {
                $allowed_tags = array_merge($allowed_tags, ['p', 'br']);
            } else {
                if (in_array('paragraphs', $this->config)) {
                    $allowed_tags = array_merge($allowed_tags, ['p', 'br']);
                }
                if (in_array('linebreaks', $this->config)) {
                    $allowed_tags = array_merge($allowed_tags, ['br']);
                }
            }
            if (in_array('lists', $this->config)) {
                $allowed_tags = array_merge($allowed_tags, ['ul', 'ol', 'li']);
            }
            if (in_array('dividers', $this->config)) {
                $allowed_tags = array_merge($allowed_tags, ['hr']);
            }
            if (in_array('media', $this->config)) {
                $allowed_tags = array_merge($allowed_tags, ['img', 'video', 'audio']);
            } else {
                if (in_array('images', $this->config)) {
                    $allowed_tags = array_merge($allowed_tags, ['img']);
                }
                if (in_array('video', $this->config)) {
                    $allowed_tags = array_merge($allowed_tags, ['video']);
                }
                if (in_array('audio', $this->config)) {
                    $allowed_tags = array_merge($allowed_tags, ['audio']);
                }
            }
        }
        // Purpousfully did not include in 'all' as to require definite opt-in
        if (in_array('danger', $this->config)) {
            $allowed_tags = array_merge($allowed_tags, ['script', 'style']);
        }
        $allowed_tags = implode(',', $allowed_tags);
        $excerpt = strip_tags($excerpt, $allowed_tags);

        // Remove empty <a> tags from previously stripped images
        $excerpt = preg_replace('/<a href=.*?><\/a>/', '', $excerpt);

        // Remove empty paragraphs
        $excerpt = str_replace(array('<p>&nbsp;</p>'), '', $excerpt);
        $excerpt = preg_replace('/(<p>\s+<\/p>)/', '', $excerpt);
        $excerpt = str_replace(array('<p></p>'), '', $excerpt);

        // Set the excerpt word count and only break after sentence is complete.
        $excerpt_word_count = (int) $this->option[0];
        $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
        $tokens = array();
        $excerpt_output = '';
        $count = 0;

        // Divide the string into tokens; HTML tags, or words, followed by any whitespace
        preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

        foreach ($tokens[0] as $key => $token) {
            $token = str_replace('&nbsp;', '', $token);
            $token = ltrim($token);

            if (empty($token)) { continue; }

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

        // cleanup variables
        unset($excerpt_output);
        unset($token);
        unset($tokens);

        // Add punctuation to the last word of paragraphs that don't have any
        $excerpt = preg_replace("/\s+\n\n+/", ". ", $excerpt);
        $excerpt = str_replace(".. ", ". ", $excerpt);

        // Remove whitespace from end
        $excerpt = rtrim($excerpt);

        $excerpt_end = '<a href="' . esc_url( get_permalink() ) . '" class="read-more">' . __('Read More', 'jetfuel') . '</a>';
        $excerpt_end = apply_filters('excerpt_more', '&hellip; ' . $excerpt_end);

        $pos = strrpos($excerpt, '</');
        if ($pos === false){
            // Add "read more" after the last character
            $excerpt = $excerpt . $excerpt_end;
        } else {
            // Add "Read More" inside last HTML tag
            $excerpt = substr_replace($excerpt, $excerpt_end, $pos, 0);
        }

        // format
        $excerpt = '<p>' . $excerpt . '</p>';

        return apply_filters('custom_excerpt', $excerpt);
    }

}
