<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: add-image-sizes
 *
 * Enables addition of image sizes, displays sizes on media settings page
 *
 * @example jetfuel('add-image-sizes');
 *
 * @link https://developer.wordpress.org/reference/hooks/the_content/
 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 * @link https://developer.wordpress.org/reference/functions/image_size_names_choose/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class AddImageSizes extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([]);
        return $this;
    }

    protected function hook() {
        // Remove the <p> tag from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
        add_filter('the_content', [$this, 'removeImgParagraph']);
        // Register custom image sizes
        add_action('after_setup_theme', [$this, 'addImageSizes']);
        // Register image sizes for use in Add Media modal
        if(is_admin()){
            add_filter('image_size_names_choose', [$this, 'addToMediaModal']);
            // Display all registered image sizes in Settings > Media
            add_action('admin_head-options-media.php', [$this, 'renderImageSizeCSS']);
            add_action('admin_init', [$this, 'listImageSizes']);
        }
    }

    public function removeImgParagraph($content){
        return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }

    public function addImageSizes() {
        //              'thumbnail'            256, 9999            Set in admin
        //              'medium'               512, 9999            Set in admin
        //              'medium_large_size_w', 768                  Not Editable
        //              'large'                1024  9999           Set in admin
        add_image_size('xlarge',              1440, 9999, false);
        add_image_size('xxlarge',             1680, 9999, false);
        add_image_size('giant',               1920, 9999, false);
        add_image_size('jumbo',               2560, 9999, false);
        //              'original'             3000+
    }

    public function addToMediaModal($sizes) {
        $sizes = array_slice( $sizes, 0, -1, true) + array(
            'xlarge'  => __('XL', 'jetfuel'),
            'xxlarge' => __('XXL', 'jetfuel'),
            'giant'   => __('Giant', 'jetfuel'),
            'jumbo'   => __('Jumbo', 'jetfuel')
         ) + array_slice( $sizes, -1, null, true);
        return $sizes;
    }

    public function renderImageSizeCSS() {
    ?><style>
        .registered-image-sizes td { padding-top: 0; padding-bottom: 2px; }
        .registered-image-sizes thead { font-weight: 600; }
        .registered-image-sizes tbody tr td:not(:first-of-type) { text-align: center; }
        .registered-image-sizes td:first-of-type { padding-left: 0; }
    </style><?php
    }

    private function sortByWidth($a, $b) {
        return $a['width'] - $b['width'];
    }

    private function getImageSizes() {
        global $_wp_additional_image_sizes;
        $sizes = array();
        $image_sizes = get_intermediate_image_sizes();

        if( ! empty( $image_sizes ) && ( is_array( $image_sizes ) || is_object( $image_sizes ) ) ) {
            foreach( $image_sizes as $image_size ) {
                if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
                    $sizes[ $image_size ]['width']  = get_option( $image_size . '_size_w' );
                    $sizes[ $image_size ]['height'] = get_option( $image_size . '_size_h' );
                    $sizes[ $image_size ]['crop']   = get_option( $image_size . '_crop' );

                    // Set defaults for medium_large
                    if ( $image_size === 'medium_large' && $sizes[ $image_size ]['width'] == 0 ) { $sizes[ $image_size ]['width'] = '768'; }
                    if ( $image_size === 'medium_large' && $sizes[ $image_size ]['height'] == 0 ) { $sizes[ $image_size ]['height'] = '9999'; }

                } elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {
                    $sizes[ $image_size ] = array(
                        'width'  => $_wp_additional_image_sizes[ $image_size ]['width'],
                        'height' => $_wp_additional_image_sizes[ $image_size ]['height'],
                        'crop'   => $_wp_additional_image_sizes[ $image_size ]['crop']
                    );
                }
            }
        }
        uasort($sizes, [$this, 'sortByWidth']);
        return $sizes;
    }

    public function renderImageSizes() {
        $image_sizes = $this->getImageSizes();

        $output = '<table class="registered-image-sizes"><thead><tr><td>' . __('Name', 'jetfuel') . '</td><td>' . __('Width', 'jetfuel') . '</td><td>' . __('Height', 'jetfuel') . '</td><td>' . __('Crop', 'jetfuel') . '</td></tr></thead><tbody>';
        foreach ( $image_sizes as $size => $meta ) {
            $output .= '<tr><td>' . esc_attr($size) . '</td><td>' . (int) $meta['width'] . '</td><td>' . (int) $meta['height'] . '</td><td>';
            if( (bool) $meta['crop'] === true ) {
                $output .= '&#x2713;';
            }
            $output .= '</td></tr></li>';
        }
        $output .= '</tbody></table>';

        echo $output;
    }

    public function listImageSizes() {
        add_settings_field(
            'image-sizes',
            __('Registered Sizes', 'jetfuel'),
            [$this, 'renderImageSizes'],
            'media',
            'default'
        );
    }
}
