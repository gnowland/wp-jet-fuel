<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: add-404
 *
 * Enables selection of 404 Page from available Pages
 *
 * @example jetfuel('add-404');
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_init
 * @link https://codex.wordpress.org/Function_Reference/register_setting
 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
 * @link https://developer.wordpress.org/reference/hooks/wp_dropdown_pages/
 * @link https://developer.wordpress.org/reference/hooks/display_post_states/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class Add404 extends Instance {

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->setDefaultConfig([]);
        return $this;
    }

    protected function hook() {
        // Add 404 Page Select to Settings > Reading
        add_action('admin_init', [$this, 'fourohfourSettings']);
        // Label 404 Page in 'Pages' List
        add_filter('display_post_states', [$this, 'fourohfourPage'], 10, 2);
    }

    public function fourohfourSelect() {
        echo '<ul style="margin-top:0;"><li>',
          wp_dropdown_pages( array(
            'name' => 'jetfuel_404',
            'echo' => 0,
            'show_option_none' =>  sprintf(
                /* translators: %1$s: &mdash; */
                __( '%1$s Select %1$s', 'jetfuel' ),
                '&mdash;'
              ),
            'option_none_value' => '0',
            'selected' => get_option( 'jetfuel_404' )
          ) ),
        '</li></ul>';
    }

    public function fourohfourSettings() {
        register_setting('reading', 'jetfuel_404', 'absint');

        add_settings_field(
            'jetfuel-404', // used for html tags only
            __('404 Page', 'jetfuel'),
            [$this, 'fourohfourSelect'],
            'reading',
            'default'
        );
    }

    public function fourohfourPage($states, $post) {
        global $post;
        $fourohfour_page = get_option('jetfuel_404');

        if ( !empty($fourohfour_page) && $post->ID == $fourohfour_page ) {
            $states[] = __('404 Page', 'jetfuel');
        }

        return $states;
    }
}
